<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProductController extends Controller
{
    public $data;

    private function setKey()
    {
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        return $stripe;
    }

    public function index()
    {
        $this->data['products'] = Product::with('tag')->paginate(20);

        return view('client.products.products',$this->data);
    }

    public function createStripeCustomer() {
        try {
            $customer = $this->setKey()->customers->create([
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
            ]);
           Customer::create(['user_id' => Auth::id(),'name' => $customer->name,'email' => $customer->email,'customer_id' => $customer->id]);

            return $customer->id;

        } catch (\Exception $e) {
            return null;
        }
    }

    public function checkout(Product $product)
    {

        session()->put(['product' => $product]);

            $customer = Customer::where('user_id',Auth::id())->first();

            $customer_id = !$customer ? $this->createStripeCustomer() : $customer->customer_id;

            $checkout_session = $this->setKey()->checkout->sessions->create([
            'customer' => $customer_id,
            'line_items' => [[
                'price_data' => [
                'currency' => 'usd',
                'product_data' => [
                    'name' => strval($product->title),
                ],
                'unit_amount' => $product->price * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('checkout.success')."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' => route('checkout.cancel'),
            ]);

            $order = new Order();
            $order->status = 1; //unpaid
            $order->user_id = Auth::id();
            $order->total = $product->price;
            $order->session_id = $checkout_session->id;
            $order->save();

            return redirect($checkout_session->url);
    }

    public function success(Request $request)
    {


         $sessionId = $request->get('session_id');

         $used = Order::where('session_id',$sessionId)->where('user_id',Auth::id())->first();

         if($used->used == 1)
         {
            abort(419);
         }

         $session = $this->setKey()->checkout->sessions->retrieve($sessionId);

         $customer = $this->setKey()->customers->retrieve($session->customer);


         if(session()->has('product'))
         {
             $product = session()->get('product');
             $user = auth()->user();
             $product->tag_id == 1 ? $user->assignRole('B2C Customer') : $user->assignRole('B2B Customer');
         }

          session()->flash('product');

        if(!$session)
        {
            abort(404);
        }

        $paymentIntentId = $session->payment_intent;

        if($paymentIntentId) {
            $paymentIntent = $this->setKey()->paymentIntents->retrieve($paymentIntentId);

            $paymentMethodId = $paymentIntent->payment_method;

            if($paymentMethodId) {
                $paymentMethod = $this->setKey()->paymentMethods->retrieve($paymentMethodId);

                $last4 = $paymentMethod->card->last4;

                Customer::where('customer_id',$customer->id)->update(['card' => $last4]);
            }
        }

        $order = Order::where('session_id',$session->id)->where('status',1)->first();

        if(!$order)
        {
            throw new NotFoundHttpException();
        }

        $order->status = 2;
        $order->used = 1;
        $order->save();

        return view('client.orders.success');
    }

    public function cancel()
    {
        return view('client.orders.cancel');
    }
}

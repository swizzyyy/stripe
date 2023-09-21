<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public $data;

    public function index()
    {
        $card = Customer::where('user_id',Auth::id())->value('card');

        if(!$card)
        {
            $this->data['card'] = '';
        }

        $this->data['card'] = $card;

        return view('client.dashboard',$this->data);
    }
}

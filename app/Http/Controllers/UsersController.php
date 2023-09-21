<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public $data;

    public function index()
    {
        $this->data['users'] = User::whereDoesntHave('roles', function($query) {
            $query->where('name', 'admin');
        })->paginate(10);

        return view('client.users.index', $this->data);
    }

    public function cancel(User $user)
    {
        $user->update(['active' => 0]);
        return redirect()->back()->with('message','User has been Deactivated');
    }

    public function grant(User $user)
    {
        $user->update(['active' => 1]);
        return redirect()->back()->with('message','User has been Activated');
    }
}

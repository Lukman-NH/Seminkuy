<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use\App\User;
use\App\Transaction;
use\App\Event;


class DashboardController extends Controller
{
    public function index()
    {   
        $user = User::count();
        $event = Event::count();
        $transaction = Transaction::count();
        return view('pages.admin.dashboard',[
            'user' => $user,
            'event' => $event,
            'transaction' => $transaction
        ]);
    }
}

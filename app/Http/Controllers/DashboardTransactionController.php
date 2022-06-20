<?php

namespace App\Http\Controllers;

use App\TransactionDetail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardTransactionController extends Controller
{
    public function index()
    {
        $buyTransactions = TransactionDetail::with(['transaction.user','event.galleries'])
        ->whereHas('transaction', function($transaction){
            $transaction->where('users_id', Auth::user()->id);
        })->get();

        return view('pages.dashboard-transactions',[
        'buyTransactions' => $buyTransactions
        ]);
    }
    public function details(Request $request, $id)
    {
        $transaction = TransactionDetail::with(['transaction.user','event.galleries'])
                            ->findOrFail($id);
        return view('pages.dashboard-transactions-details',[
            'transaction' => $transaction
        ]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        $item = TransactionDetail::findOrFail($id);

        $item->update($data);

        return redirect()->route('dashboard-transaction-details', $id);
    }
}

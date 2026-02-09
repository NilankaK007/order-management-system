<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $pendingOrders = Order::where('user_id', $user->id)
            ->where('status', 'pending')
            ->orderBy('delivery_date', 'asc')
            ->get();
        
        $previousOrders = Order::where('user_id', $user->id)
            ->where('status', 'completed')
            ->orderBy('updated_at', 'desc')
            ->get();

        $totalIncome = Transaction::where('user_id', $user->id)
            ->where('type', 'income')
            ->sum('amount');

        $totalOutcome = Transaction::where('user_id', $user->id)
            ->where('type', 'outcome')
            ->sum('amount');

        $profit = $totalIncome - $totalOutcome;

        return view('dashboard', compact(
            'pendingOrders', 
            'previousOrders', 
            'totalIncome', 
            'totalOutcome', 
            'profit'
        ));
    }
}
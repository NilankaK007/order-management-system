<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Transaction;

class OrderController extends Controller
{
    public function create()
    {
        return view('orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'order_date' => 'required|date',
            'delivery_date' => 'required|date|after_or_equal:order_date',
        ]);

        Order::create([
            'user_id' => auth()->id(),
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'description' => $request->description,
            'price' => $request->price,
            'order_date' => $request->order_date,
            'delivery_date' => $request->delivery_date,
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('success', 'Order added successfully!');
    }

    public function complete($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Update order status
        $order->update(['status' => 'completed']);

        // Create income transaction
        Transaction::create([
            'user_id' => auth()->id(),
            'type' => 'income',
            'amount' => $order->price,
            'description' => 'Order #' . $order->id . ' - ' . $order->customer_name,
            'date' => now()->toDateString(),
        ]);

        return redirect()->route('dashboard')->with('success', 'Order completed and income recorded!');
    }

    public function show($id)
    {
        $order = Order::where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('orders.show', compact('order'));
    }
}
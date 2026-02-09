<!DOCTYPE html>
<html>
<head>
    <title>Order Details</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .container { max-width: 700px; margin: 50px auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 30px; color: #333; border-bottom: 3px solid #4CAF50; padding-bottom: 10px; }
        .detail-row { display: flex; margin-bottom: 20px; padding: 10px; background: #f9f9f9; border-radius: 4px; }
        .detail-label { font-weight: bold; color: #555; width: 180px; }
        .detail-value { color: #333; flex: 1; }
        .status { display: inline-block; padding: 6px 15px; border-radius: 20px; font-size: 13px; font-weight: bold; }
        .status.pending { background: #fff3cd; color: #856404; }
        .status.completed { background: #d4edda; color: #155724; }
        .price { font-size: 24px; font-weight: bold; color: #4CAF50; }
        .back-btn { display: inline-block; margin-top: 30px; padding: 12px 30px; background: #4CAF50; color: white; text-decoration: none; border-radius: 4px; }
        .back-btn:hover { background: #45a049; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Order Details</h2>
        
        <div class="detail-row">
            <div class="detail-label">Order ID:</div>
            <div class="detail-value">#{{ $order->id }}</div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Customer Name:</div>
            <div class="detail-value">{{ $order->customer_name }}</div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Customer Address:</div>
            <div class="detail-value">{{ $order->customer_address }}</div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Description:</div>
            <div class="detail-value">{{ $order->description }}</div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Price:</div>
            <div class="detail-value"><span class="price">Rs {{ number_format($order->price, 2) }}</span></div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Order Date:</div>
            <div class="detail-value">{{ $order->order_date->format('F d, Y') }}</div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Delivery Date:</div>
            <div class="detail-value">{{ $order->delivery_date->format('F d, Y') }}</div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Status:</div>
            <div class="detail-value">
                <span class="status {{ $order->status }}">{{ ucfirst($order->status) }}</span>
            </div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Created At:</div>
            <div class="detail-value">{{ $order->created_at->format('F d, Y h:i A') }}</div>
        </div>

        @if($order->status == 'completed')
        <div class="detail-row">
            <div class="detail-label">Completed At:</div>
            <div class="detail-value">{{ $order->updated_at->format('F d, Y h:i A') }}</div>
        </div>
        @endif
        
        <a href="{{ route('dashboard') }}" class="back-btn">← Back to Dashboard</a>
    </div>
</body>
</html>
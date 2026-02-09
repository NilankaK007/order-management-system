<!DOCTYPE html>
<html>
<head>
    <title>Add New Order</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .header { background: #4CAF50; color: white; padding: 20px; }
        .header h1 { font-size: 24px; }
        .container { max-width: 800px; margin: 30px auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 30px; color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #555; font-weight: bold; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; font-family: Arial, sans-serif; }
        input:focus, textarea:focus { outline: none; border-color: #4CAF50; }
        textarea { min-height: 100px; resize: vertical; }
        .button-group { display: flex; gap: 10px; margin-top: 30px; }
        button, .btn { padding: 12px 30px; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; text-decoration: none; display: inline-block; text-align: center; }
        .btn-primary { background: #4CAF50; color: white; }
        .btn-primary:hover { background: #45a049; }
        .btn-secondary { background: #666; color: white; }
        .btn-secondary:hover { background: #555; }
        .error { color: red; font-size: 12px; margin-top: 5px; }
        .success { color: green; background: #d4edda; padding: 10px; border-radius: 4px; margin-bottom: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ auth()->user()->business_name }}</h1>
    </div>

    <div class="container">
        <h2>Add New Order</h2>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('orders.store') }}">
            @csrf
            
            <div class="form-group">
                <label>Customer Name *</label>
                <input type="text" name="customer_name" value="{{ old('customer_name') }}" required>
                @error('customer_name')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Customer Address *</label>
                <textarea name="customer_address" required>{{ old('customer_address') }}</textarea>
                @error('customer_address')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Order Description *</label>
                <textarea name="description" required>{{ old('description') }}</textarea>
                @error('description')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Price (Rs) *</label>
                <input type="number" name="price" step="0.01" min="0" value="{{ old('price') }}" required>
                @error('price')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Order Date *</label>
                <input type="date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}" required>
                @error('order_date')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label>Delivery Date *</label>
                <input type="date" name="delivery_date" value="{{ old('delivery_date') }}" required>
                @error('delivery_date')<div class="error">{{ $message }}</div>@enderror
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Add Order</button>
                <a href="{{ route('dashboard') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
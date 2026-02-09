<!DOCTYPE html>
<html>
<head>
    <title>Financial Transactions</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .header { background: #4CAF50; color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .logout-btn { background: white; color: #4CAF50; padding: 8px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .stat-card h3 { color: #666; font-size: 14px; margin-bottom: 10px; text-transform: uppercase; }
        .stat-card .amount { font-size: 32px; font-weight: bold; }
        .stat-card.income .amount { color: #4CAF50; }
        .stat-card.outcome .amount { color: #f44336; }
        .stat-card.profit .amount { color: #2196F3; }
        .section { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #4CAF50; padding-bottom: 10px; }
        .section h2 { color: #333; }
        .btn { padding: 8px 16px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; font-size: 14px; }
        .btn-add { background: #4CAF50; color: white; }
        .btn-add:hover { background: #45a049; }
        .btn-back { background: #666; color: white; margin-right: 10px; }
        .btn-back:hover { background: #555; }
        .btn-delete { background: #f44336; color: white; }
        .btn-delete:hover { background: #da190b; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f9f9f9; font-weight: bold; color: #555; }
        .no-data { text-align: center; color: #999; padding: 20px; }
        .success-message { background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .type-badge { padding: 4px 12px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .type-badge.income { background: #d4edda; color: #155724; }
        .type-badge.outcome { background: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ auth()->user()->business_name }} - Financial Transactions</h1>
        <form method="POST" action="{{ route('logout') }}" style="display: inline;">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="container">
        @if(session('success'))
            <div class="success-message">{{ session('success') }}</div>
        @endif

        <div class="stats">
            <div class="stat-card income">
                <h3>Total Income</h3>
                <div class="amount">Rs {{ number_format($transactions->where('type', 'income')->sum('amount'), 2) }}</div>
            </div>
            <div class="stat-card outcome">
                <h3>Total Outcome</h3>
                <div class="amount">Rs {{ number_format($transactions->where('type', 'outcome')->sum('amount'), 2) }}</div>
            </div>
            <div class="stat-card profit">
                <h3>Net Profit</h3>
                <div class="amount">Rs {{ number_format($transactions->where('type', 'income')->sum('amount') - $transactions->where('type', 'outcome')->sum('amount'), 2) }}</div>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <h2>All Transactions</h2>
                <div>
                    <a href="{{ route('dashboard') }}" class="btn btn-back">← Back to Dashboard</a>
                    <a href="{{ route('transactions.create') }}" class="btn btn-add">+ Add Transaction</a>
                </div>
            </div>
            @if($transactions->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Description</th>
                            <th>Amount</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ \Carbon\Carbon::parse($transaction->date)->format('Y-m-d') }}</td>
                            <td><span class="type-badge {{ $transaction->type }}">{{ ucfirst($transaction->type) }}</span></td>
                            <td>{{ $transaction->description }}</td>
                            <td style="color: {{ $transaction->type == 'income' ? '#4CAF50' : '#f44336' }}; font-weight: bold;">
                                {{ $transaction->type == 'income' ? '+' : '-' }} Rs {{ number_format($transaction->amount, 2) }}
                            </td>
                            <td>
                                <form method="POST" action="{{ route('transactions.destroy', $transaction->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-delete" onclick="return confirm('Delete this transaction?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="no-data">No transactions yet. Click "Add Transaction" to create one.</div>
            @endif
        </div>
    </div>
</body>
</html>
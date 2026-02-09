<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .header { background: #4CAF50; color: white; padding: 20px; display: flex; justify-content: space-between; align-items: center; }
        .header h1 { font-size: 24px; }
        .header-right { display: flex; gap: 10px; align-items: center; }
        .nav-btn { background: transparent; color: white; padding: 8px 20px; border: 2px solid white; border-radius: 4px; cursor: pointer; text-decoration: none; display: inline-block; }
        .nav-btn:hover { background: white; color: #4CAF50; }
        .logout-btn { background: white; color: #4CAF50; padding: 8px 20px; border: none; border-radius: 4px; cursor: pointer; }
        .logout-btn:hover { background: #f0f0f0; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; }
        .stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); cursor: pointer; transition: transform 0.2s; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 4px 10px rgba(0,0,0,0.15); }
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
        .btn-view { background: #2196F3; color: white; }
        .btn-view:hover { background: #0b7dda; }
        .btn-complete { background: #FF9800; color: white; }
        .btn-complete:hover { background: #e68900; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background: #f9f9f9; font-weight: bold; color: #555; }
        .no-data { text-align: center; color: #999; padding: 20px; }
        .success-message { background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .action-buttons { display: flex; gap: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1><?php echo e(auth()->user()->business_name); ?></h1>
        <div class="header-right">
            <a href="<?php echo e(route('transactions.index')); ?>" class="nav-btn">Manage Finances</a>
            <form method="POST" action="<?php echo e(route('logout')); ?>" style="display: inline;">
                <?php echo csrf_field(); ?>
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="container">
        <?php if(session('success')): ?>
            <div class="success-message"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        <div class="stats">
            <div class="stat-card income" onclick="window.location.href='<?php echo e(route('transactions.index')); ?>'">
                <h3>Total Income</h3>
                <div class="amount">Rs <?php echo e(number_format($totalIncome, 2)); ?></div>
            </div>
            <div class="stat-card outcome" onclick="window.location.href='<?php echo e(route('transactions.index')); ?>'">
                <h3>Total Outcome</h3>
                <div class="amount">Rs <?php echo e(number_format($totalOutcome, 2)); ?></div>
            </div>
            <div class="stat-card profit">
                <h3>Net Profit</h3>
                <div class="amount">Rs <?php echo e(number_format($profit, 2)); ?></div>
            </div>
        </div>

        <div class="section">
            <div class="section-header">
                <h2>Pending Orders</h2>
                <a href="<?php echo e(route('orders.create')); ?>" class="btn btn-add">+ Add Order</a>
            </div>
            <?php if($pendingOrders->count() > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Address</th>
                            <th>Price</th>
                            <th>Order Date</th>
                            <th>Delivery Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $pendingOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($order->customer_name); ?></td>
                            <td><?php echo e(Str::limit($order->customer_address, 30)); ?></td>
                            <td>Rs <?php echo e(number_format($order->price, 2)); ?></td>
                            <td><?php echo e($order->order_date->format('Y-m-d')); ?></td>
                            <td><?php echo e($order->delivery_date->format('Y-m-d')); ?></td>
                            <td>
                                <div class="action-buttons">
                                    <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-view">View</a>
                                    <form method="POST" action="<?php echo e(route('orders.complete', $order->id)); ?>" style="display: inline;">
                                        <?php echo csrf_field(); ?>
                                        <button type="submit" class="btn btn-complete" onclick="return confirm('Mark this order as completed?')">Complete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">No pending orders. Click "Add Order" to create one.</div>
            <?php endif; ?>
        </div>

        <div class="section">
            <div class="section-header">
                <h2>Previous Orders</h2>
            </div>
            <?php if($previousOrders->count() > 0): ?>
                <table>
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Address</th>
                            <th>Price</th>
                            <th>Order Date</th>
                            <th>Completed Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $previousOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($order->customer_name); ?></td>
                            <td><?php echo e(Str::limit($order->customer_address, 30)); ?></td>
                            <td>Rs <?php echo e(number_format($order->price, 2)); ?></td>
                            <td><?php echo e($order->order_date->format('Y-m-d')); ?></td>
                            <td><?php echo e($order->updated_at->format('Y-m-d')); ?></td>
                            <td>
                                <a href="<?php echo e(route('orders.show', $order->id)); ?>" class="btn btn-view">View</a>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="no-data">No completed orders yet.</div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\order management\order-management\resources\views/dashboard.blade.php ENDPATH**/ ?>
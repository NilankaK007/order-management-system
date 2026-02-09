<!DOCTYPE html>
<html>
<head>
    <title>Add Transaction</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        .header { background: #4CAF50; color: white; padding: 20px; }
        .header h1 { font-size: 24px; }
        .container { max-width: 700px; margin: 30px auto; background: white; padding: 40px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h2 { margin-bottom: 30px; color: #333; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; color: #555; font-weight: bold; }
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 14px; font-family: Arial, sans-serif; }
        input:focus, textarea:focus, select:focus { outline: none; border-color: #4CAF50; }
        textarea { min-height: 100px; resize: vertical; }
        .button-group { display: flex; gap: 10px; margin-top: 30px; }
        button, .btn { padding: 12px 30px; border: none; border-radius: 4px; font-size: 16px; cursor: pointer; text-decoration: none; display: inline-block; text-align: center; }
        .btn-primary { background: #4CAF50; color: white; }
        .btn-primary:hover { background: #45a049; }
        .btn-secondary { background: #666; color: white; }
        .btn-secondary:hover { background: #555; }
        .error { color: red; font-size: 12px; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1><?php echo e(auth()->user()->business_name); ?></h1>
    </div>

    <div class="container">
        <h2>Add New Transaction</h2>

        <form method="POST" action="<?php echo e(route('transactions.store')); ?>">
            <?php echo csrf_field(); ?>
            
            <div class="form-group">
                <label>Transaction Type *</label>
                <select name="type" required>
                    <option value="">Select Type</option>
                    <option value="income" <?php echo e(old('type') == 'income' ? 'selected' : ''); ?>>Income</option>
                    <option value="outcome" <?php echo e(old('type') == 'outcome' ? 'selected' : ''); ?>>Outcome (Expense)</option>
                </select>
                <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label>Amount (Rs) *</label>
                <input type="number" name="amount" step="0.01" min="0" value="<?php echo e(old('amount')); ?>" required>
                <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label>Description *</label>
                <textarea name="description" required><?php echo e(old('description')); ?></textarea>
                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="form-group">
                <label>Date *</label>
                <input type="date" name="date" value="<?php echo e(old('date', date('Y-m-d'))); ?>" required>
                <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-primary">Add Transaction</button>
                <a href="<?php echo e(route('transactions.index')); ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html><?php /**PATH C:\xampp\htdocs\order management\order-management\resources\views/transactions/create.blade.php ENDPATH**/ ?>
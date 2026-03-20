<?php $__env->startSection('title','Add Transaction'); ?>
<?php $__env->startSection('page-title','Add Transaction'); ?>
<?php $__env->startSection('topbar-actions'); ?>
<a href="<?php echo e(route('expenses.index')); ?>" class="btn btn-outline btn-sm">← Back</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<nav class="breadcrumb">
  <a href="<?php echo e(route('expenses.index')); ?>">Transactions</a><span>›</span><span>Add New</span>
</nav>

<form method="POST" action="<?php echo e(route('expenses.store')); ?>" novalidate>
<?php echo csrf_field(); ?>
<div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start">
  <div>
    
    <div class="card">
      <div class="card-header"><div class="card-title">Transaction Type</div></div>
      <div class="card-body">
        <div class="type-toggle">
          <input type="radio" name="type" id="type_expense" value="expense" <?php echo e(old('type','expense') === 'expense' ? 'checked' : ''); ?>>
          <label for="type_expense" class="toggle-expense">💸 Expense</label>
          <input type="radio" name="type" id="type_income" value="income" <?php echo e(old('type') === 'income' ? 'checked' : ''); ?>>
          <label for="type_income" class="toggle-income">💰 Income</label>
        </div>
        <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
    </div>

    
    <div class="card">
      <div class="card-header"><div class="card-title">Transaction Details</div></div>
      <div class="card-body">
        <div class="form-grid">
          <div class="form-group full">
            <label class="form-label">Title <span class="req">*</span></label>
            <input class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="title" value="<?php echo e(old('title')); ?>" placeholder="e.g. Grocery Shopping" required>
            <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          <div class="form-group">
            <label class="form-label">Amount (₹) <span class="req">*</span></label>
            <input class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="number" name="amount" value="<?php echo e(old('amount')); ?>" placeholder="0.00" step="0.01" min="0.01" required>
            <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          <div class="form-group">
            <label class="form-label">Date <span class="req">*</span></label>
            <input class="form-control <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="date" name="date" value="<?php echo e(old('date', now()->toDateString())); ?>" max="<?php echo e(now()->toDateString()); ?>" required>
            <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          <div class="form-group">
            <label class="form-label">Category <span class="req">*</span></label>
            <select class="form-select <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="category_id" required>
              <option value="" disabled <?php if(!old('category_id')): echo 'selected'; endif; ?>>Select category…</option>
              <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($cat->id); ?>" <?php if(old('category_id') == $cat->id): echo 'selected'; endif; ?>><?php echo e($cat->icon); ?> <?php echo e($cat->name); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['category_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          <div class="form-group">
            <label class="form-label">Payment Method <span class="req">*</span></label>
            <select class="form-select <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="payment_method" required>
              <?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($pm); ?>" <?php if(old('payment_method','Cash') === $pm): echo 'selected'; endif; ?>><?php echo e($pm); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          <div class="form-group">
            <label class="form-label">Reference / Invoice No</label>
            <input class="form-control" type="text" name="reference" value="<?php echo e(old('reference')); ?>" placeholder="Optional">
          </div>
          <div class="form-group full">
            <label class="form-label">Description</label>
            <textarea class="form-control" name="description" rows="2" placeholder="Optional notes…"><?php echo e(old('description')); ?></textarea>
          </div>
          <div class="form-group full">
            <label class="form-label">Tags</label>
            <input class="form-control" type="text" name="tags" value="<?php echo e(old('tags')); ?>" placeholder="Comma separated: food, monthly, work">
            <div class="form-hint">Separate tags with commas</div>
          </div>
        </div>
      </div>
    </div>

    
    <div class="card">
      <div class="card-header"><div class="card-title">Recurring</div></div>
      <div class="card-body">
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
          <input type="checkbox" id="is_recurring" name="is_recurring" value="1" <?php echo e(old('is_recurring') ? 'checked' : ''); ?> style="width:16px;height:16px;accent-color:var(--primary)">
          <label for="is_recurring" style="font-size:13.5px;font-weight:600;cursor:pointer">This is a recurring transaction</label>
        </div>
        <div id="recurring_period_wrap" style="display:none">
          <div class="form-group">
            <label class="form-label">Recurring Period</label>
            <select class="form-select <?php $__errorArgs = ['recurring_period'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="recurring_period">
              <option value="">Select period…</option>
              <?php $__currentLoopData = ['daily'=>'Daily','weekly'=>'Weekly','monthly'=>'Monthly','yearly'=>'Yearly']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($val); ?>" <?php if(old('recurring_period') === $val): echo 'selected'; endif; ?>><?php echo e($lbl); ?></option>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <?php $__errorArgs = ['recurring_period'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  
  <div>
    <div class="card">
      <div class="card-body">
        <p style="font-size:12.5px;color:var(--muted);line-height:1.6;margin-bottom:16px">
          Fill in all required fields marked with <span class="req">*</span> and click Save.
        </p>
        <button type="submit" class="btn btn-primary" style="width:100%">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
          Save Transaction
        </button>
        <a href="<?php echo e(route('expenses.index')); ?>" class="btn btn-outline" style="width:100%;margin-top:8px;justify-content:center">Cancel</a>
      </div>
    </div>
  </div>
</div>
</form>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\expensetracker\resources\views/expenses/create.blade.php ENDPATH**/ ?>
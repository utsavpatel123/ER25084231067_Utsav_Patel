<?php $__env->startSection('title', e($expense->title)); ?>
<?php $__env->startSection('page-title', 'Transaction Detail'); ?>
<?php $__env->startSection('topbar-actions'); ?>
<a href="<?php echo e(route('expenses.edit', $expense)); ?>" class="btn btn-outline btn-sm">Edit</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<nav class="breadcrumb">
  <a href="<?php echo e(route('expenses.index')); ?>">Transactions</a><span>›</span>
  <span><?php echo e(e($expense->title)); ?></span>
</nav>

<div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start">
  <div>
    <div class="card">
      <div style="padding:24px;border-bottom:1px solid var(--border);display:flex;align-items:flex-start;gap:16px">
        <div style="width:56px;height:56px;border-radius:14px;background:<?php echo e($expense->type === 'income' ? 'var(--income-l)' : 'var(--expense-l)'); ?>;display:flex;align-items:center;justify-content:center;font-size:24px;flex-shrink:0">
          <?php echo e($expense->category?->icon ?? '💸'); ?>

        </div>
        <div style="flex:1">
          <div style="font-size:20px;font-weight:800;color:var(--text)"><?php echo e(e($expense->title)); ?></div>
          <div style="margin-top:6px;display:flex;align-items:center;gap:8px;flex-wrap:wrap">
            <span class="badge badge-<?php echo e($expense->type === 'income' ? 'income' : 'expense'); ?>"><?php echo e(ucfirst($expense->type)); ?></span>
            <span class="badge badge-gray"><?php echo e($expense->category?->name); ?></span>
            <span class="badge badge-gray"><?php echo e($expense->payment_method); ?></span>
            <?php if($expense->is_recurring): ?><span class="badge badge-blue">🔄 <?php echo e(ucfirst($expense->recurring_period)); ?></span><?php endif; ?>
          </div>
        </div>
        <div style="text-align:right;flex-shrink:0">
          <div style="font-size:28px;font-weight:800;color:<?php echo e($expense->type === 'income' ? 'var(--income)' : 'var(--expense)'); ?>">
            <?php echo e($expense->type === 'income' ? '+' : '-'); ?>₹<?php echo e(number_format($expense->amount,2)); ?>

          </div>
          <div style="font-size:13px;color:var(--muted);margin-top:4px"><?php echo e($expense->date->format('d F Y')); ?></div>
        </div>
      </div>

      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1px;background:var(--border)">
        <div class="info-cell"><div class="info-label">Date</div><div class="info-value"><?php echo e($expense->date->format('d M Y')); ?></div></div>
        <div class="info-cell"><div class="info-label">Payment Method</div><div class="info-value"><?php echo e($expense->payment_method); ?></div></div>
        <div class="info-cell"><div class="info-label">Category</div><div class="info-value"><?php echo e($expense->category?->icon); ?> <?php echo e($expense->category?->name); ?></div></div>
        <div class="info-cell"><div class="info-label">Reference</div><div class="info-value"><?php echo e($expense->reference ?: '—'); ?></div></div>
        <?php if($expense->description): ?>
        <div class="info-cell" style="grid-column:1/-1">
          <div class="info-label">Description</div>
          <div class="info-value"><?php echo e($expense->description); ?></div>
        </div>
        <?php endif; ?>
        <?php if($expense->tags): ?>
        <div class="info-cell" style="grid-column:1/-1">
          <div class="info-label">Tags</div>
          <div class="info-value" style="display:flex;gap:5px;flex-wrap:wrap;margin-top:4px">
            <?php $__currentLoopData = $expense->tags_array; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <span class="badge badge-gray"><?php echo e($tag); ?></span>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div>
    <div class="card" style="margin-bottom:14px">
      <div class="card-body">
        <div style="font-size:12.5px;color:var(--muted);line-height:2">
          <div><strong style="color:var(--text2)">Created:</strong> <?php echo e($expense->created_at->format('d M Y, h:i A')); ?></div>
          <div><strong style="color:var(--text2)">Last Updated:</strong> <?php echo e($expense->updated_at->diffForHumans()); ?></div>
        </div>
      </div>
    </div>
    <a href="<?php echo e(route('expenses.edit', $expense)); ?>" class="btn btn-primary" style="width:100%;justify-content:center;margin-bottom:8px;display:flex">Edit Transaction</a>
    <a href="<?php echo e(route('expenses.index')); ?>" class="btn btn-outline" style="width:100%;justify-content:center;margin-bottom:8px;display:flex">← All Transactions</a>
    <form method="POST" action="<?php echo e(route('expenses.destroy', $expense)); ?>" id="del-show">
      <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
      <button type="button" class="btn btn-ghost" style="width:100%;color:var(--danger);justify-content:center"
        onclick="confirmDelete(document.getElementById('del-show'),'<?php echo e(e($expense->title)); ?>')">Delete</button>
    </form>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\expensetracker\resources\views/expenses/show.blade.php ENDPATH**/ ?>
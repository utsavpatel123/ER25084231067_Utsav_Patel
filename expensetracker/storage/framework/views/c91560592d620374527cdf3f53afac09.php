<?php $__env->startSection('title','Budgets'); ?>
<?php $__env->startSection('page-title','Budgets'); ?>

<?php $__env->startSection('content'); ?>

<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start">

  
  <div>
    <?php if($budgets->isEmpty()): ?>
      <div class="card">
        <div class="empty-state">
          <div class="empty-state-icon">📊</div>
          <h3>No budgets set</h3>
          <p>Create a budget on the right to start tracking your spending limits.</p>
        </div>
      </div>
    <?php else: ?>
    <div class="budget-grid">
      <?php $__currentLoopData = $budgets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php
        $pct      = $b->percent_used;
        $status   = $b->status;
        $barClass = $status === 'exceeded' ? 'prog-red' : ($status === 'warning' ? 'prog-amber' : 'prog-green');
        $badgeColor = $status === 'exceeded' ? 'red' : ($status === 'warning' ? 'amber' : 'green');
        $statusLabel = ['exceeded'=>'Over Budget','warning'=>'Near Limit','good'=>'On Track'][$status];
      ?>
      <div class="budget-card">
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
          <div style="display:flex;align-items:center;gap:8px">
            <span style="font-size:22px"><?php echo e($b->category?->icon ?? '📦'); ?></span>
            <div>
              <div style="font-weight:700;font-size:14px"><?php echo e(e($b->name)); ?></div>
              <div style="font-size:11.5px;color:var(--muted)">
                <?php echo e(ucfirst($b->period)); ?> · <?php echo e($b->period_month ? date('M', mktime(0,0,0,$b->period_month,1)) . ' ' : ''); ?><?php echo e($b->period_year); ?>

              </div>
            </div>
          </div>
          <span class="badge badge-<?php echo e($badgeColor); ?>"><?php echo e($statusLabel); ?></span>
        </div>

        <div style="margin-bottom:8px">
          <div style="display:flex;justify-content:space-between;font-size:13px;margin-bottom:5px">
            <span style="color:var(--muted)">₹<?php echo e(number_format($b->spent,2)); ?> spent</span>
            <span style="font-weight:700">₹<?php echo e(number_format($b->amount,2)); ?> budget</span>
          </div>
          <div class="progress" style="height:8px">
            <div class="progress-bar <?php echo e($barClass); ?>" style="width:<?php echo e($pct); ?>%"></div>
          </div>
          <div style="display:flex;justify-content:space-between;font-size:11px;color:var(--muted);margin-top:4px">
            <span><?php echo e($pct); ?>% used</span>
            <?php if($b->remaining >= 0): ?>
              <span style="color:var(--success)">₹<?php echo e(number_format($b->remaining,2)); ?> left</span>
            <?php else: ?>
              <span style="color:var(--danger)">₹<?php echo e(number_format(abs($b->remaining),2)); ?> over</span>
            <?php endif; ?>
          </div>
        </div>

        <div style="display:flex;justify-content:flex-end;gap:6px;padding-top:10px;border-top:1px solid var(--border)">
          <button type="button" class="btn btn-outline btn-xs"
            onclick="openEditBudget(<?php echo e($b->id); ?>,'<?php echo e(e($b->name)); ?>',<?php echo e($b->category_id ?? 'null'); ?>,<?php echo e($b->amount); ?>,'<?php echo e($b->period); ?>',<?php echo e($b->period_year); ?>,<?php echo e($b->period_month ?? 'null'); ?>)">
            Edit
          </button>
          <form method="POST" action="<?php echo e(route('budgets.destroy', $b)); ?>" id="bgt-del-<?php echo e($b->id); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button type="button" class="btn btn-xs" style="background:var(--danger-l);color:var(--danger);border:1px solid #fecaca"
              onclick="confirmDelete(document.getElementById('bgt-del-<?php echo e($b->id); ?>'),'<?php echo e(e($b->name)); ?>')">Delete</button>
          </form>
        </div>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php endif; ?>
  </div>

  
  <div>
    <div class="card">
      <div class="card-header"><div class="card-title" id="bgt-form-title">Add Budget</div></div>
      <div class="card-body">

        
        <form method="POST" action="<?php echo e(route('budgets.store')); ?>" novalidate id="bgt-add-form">
          <?php echo csrf_field(); ?>
          <?php echo $__env->make('budgets._form', ['b' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          <button type="submit" class="btn btn-primary" style="width:100%;margin-top:16px">Add Budget</button>
        </form>

        
        <form method="POST" id="bgt-edit-form" style="display:none">
          <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
          <?php echo $__env->make('budgets._form', ['b' => null], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
          <button type="submit" class="btn btn-primary" style="width:100%;margin-top:16px">Save Changes</button>
          <button type="button" class="btn btn-outline" style="width:100%;margin-top:8px" onclick="cancelBgtEdit()">Cancel</button>
        </form>

      </div>
    </div>
  </div>

</div>

<?php $__env->startPush('scripts'); ?>
<script>
function openEditBudget(id, name, catId, amount, period, year, month) {
  document.getElementById('bgt-form-title').textContent = 'Edit Budget';
  document.getElementById('bgt-add-form').style.display = 'none';
  const form = document.getElementById('bgt-edit-form');
  form.action = '/budgets/' + id;
  form.style.display = '';
  form.querySelector('[name="name"]').value         = name;
  form.querySelector('[name="category_id"]').value  = catId || '';
  form.querySelector('[name="amount"]').value       = amount;
  form.querySelector('[name="period"]').value       = period;
  form.querySelector('[name="period_year"]').value  = year;
  form.querySelector('[name="period_month"]').value = month || '';
}
function cancelBgtEdit() {
  document.getElementById('bgt-form-title').textContent = 'Add Budget';
  document.getElementById('bgt-add-form').style.display = '';
  document.getElementById('bgt-edit-form').style.display = 'none';
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\25084231020_Ashish\expensetracker\resources\views/budgets/index.blade.php ENDPATH**/ ?>
<?php $__env->startSection('title','Reports'); ?>
<?php $__env->startSection('page-title','Reports & Analytics'); ?>

<?php $__env->startSection('content'); ?>

<form method="GET" action="<?php echo e(route('reports.index')); ?>" class="filters-bar">
  <select class="form-select" name="year" onchange="this.form.submit()" style="width:110px">
    <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($y); ?>" <?php if($year == $y): echo 'selected'; endif; ?>><?php echo e($y); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
  <select class="form-select" name="month" onchange="this.form.submit()" style="width:130px">
    <option value="0">All Months</option>
    <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($num); ?>" <?php if($month == $num): echo 'selected'; endif; ?>><?php echo e($name); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
</form>


<div class="stats-grid" style="grid-template-columns:repeat(3,1fr);margin-bottom:24px">
  <div class="stat-card">
    <div class="stat-icon-wrap red">💸</div>
    <div class="stat-body">
      <div class="stat-label">Total Expense</div>
      <div class="stat-value expense-val">₹<?php echo e(number_format($expenses,2)); ?></div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon-wrap green">💰</div>
    <div class="stat-body">
      <div class="stat-label">Total Income</div>
      <div class="stat-value income-val">₹<?php echo e(number_format($incomes,2)); ?></div>
    </div>
  </div>
  <div class="stat-card">
    <?php $net = $incomes - $expenses; ?>
    <div class="stat-icon-wrap <?php echo e($net >= 0 ? 'blue' : 'amber'); ?>">⚖️</div>
    <div class="stat-body">
      <div class="stat-label">Net Balance</div>
      <div class="stat-value" style="color:<?php echo e($net >= 0 ? 'var(--income)' : 'var(--expense)'); ?>">
        <?php echo e($net >= 0 ? '+' : ''); ?>₹<?php echo e(number_format(abs($net),2)); ?>

      </div>
    </div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start">
  <div>
    
    <div class="card" style="margin-bottom:20px">
      <div class="card-header"><div class="card-title">Monthly Breakdown — <?php echo e($year); ?></div></div>
      <div class="table-wrap">
        <table>
          <thead><tr><th>Month</th><th>Expense</th><th>Income</th><th>Net</th><th>Savings Rate</th></tr></thead>
          <tbody>
            <?php $__currentLoopData = $monthly; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $net = $data['income'] - $data['expense']; $rate = $data['income'] > 0 ? round($net/$data['income']*100) : 0; ?>
            <tr>
              <td style="font-weight:600"><?php echo e($data['label']); ?></td>
              <td class="amount-expense"><?php if($data['expense'] > 0): ?> ₹<?php echo e(number_format($data['expense'],2)); ?> <?php else: ?> — <?php endif; ?></td>
              <td class="amount-income"><?php if($data['income'] > 0): ?> ₹<?php echo e(number_format($data['income'],2)); ?> <?php else: ?> — <?php endif; ?></td>
              <td style="font-weight:700;color:<?php echo e($net >= 0 ? 'var(--income)' : 'var(--expense)'); ?>">
                <?php if($data['expense'] > 0 || $data['income'] > 0): ?> <?php echo e($net >= 0 ? '+' : ''); ?>₹<?php echo e(number_format(abs($net),2)); ?> <?php else: ?> — <?php endif; ?>
              </td>
              <td>
                <?php if($data['income'] > 0): ?>
                  <div style="display:flex;align-items:center;gap:8px;min-width:100px">
                    <div class="progress" style="flex:1">
                      <div class="progress-bar <?php echo e($rate >= 20 ? 'prog-green' : ($rate >= 0 ? 'prog-amber' : 'prog-red')); ?>" style="width:<?php echo e(max(0,min(100,$rate))); ?>%"></div>
                    </div>
                    <span style="font-size:12px;color:var(--muted);width:34px"><?php echo e($rate); ?>%</span>
                  </div>
                <?php else: ?> — <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    </div>

    
    <?php if($byPayment->count()): ?>
    <div class="card">
      <div class="card-header"><div class="card-title">Expense by Payment Method</div></div>
      <div class="card-body">
        <?php $pmMax = $byPayment->max('total') ?: 1; ?>
        <?php $__currentLoopData = $byPayment; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="margin-bottom:14px">
          <div style="display:flex;justify-content:space-between;margin-bottom:5px;font-size:13px">
            <span style="font-weight:600"><?php echo e($pm->payment_method); ?></span>
            <span class="amount-expense">₹<?php echo e(number_format($pm->total,2)); ?></span>
          </div>
          <div class="progress">
            <div class="progress-bar prog-blue" style="width:<?php echo e(round($pm->total/$pmMax*100)); ?>%"></div>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
    <?php endif; ?>
  </div>

  
  <div>
    <div class="card">
      <div class="card-header"><div class="card-title">Expense by Category</div></div>
      <?php if($byCategory->isEmpty()): ?>
        <div class="empty-state" style="padding:30px"><p>No expense data for this period.</p></div>
      <?php else: ?>
      <?php $catMax = $byCategory->max('total') ?: 1; ?>
      <div class="card-body" style="padding:12px 16px">
        <?php $__currentLoopData = $byCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div style="margin-bottom:14px">
          <div style="display:flex;justify-content:space-between;margin-bottom:5px;font-size:13px">
            <span style="display:flex;align-items:center;gap:6px;font-weight:600">
              <span><?php echo e($cat->icon); ?></span><?php echo e(e($cat->name)); ?>

            </span>
            <span class="amount-expense">₹<?php echo e(number_format($cat->total,2)); ?></span>
          </div>
          <div class="progress">
            <div class="progress-bar" style="width:<?php echo e(round($cat->total/$catMax*100)); ?>%;background:<?php echo e($cat->color); ?>"></div>
          </div>
          <div style="font-size:11px;color:var(--muted);margin-top:3px;text-align:right">
            <?php echo e($expenses > 0 ? round($cat->total/$expenses*100) : 0); ?>% of total
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\expensetracker\resources\views/reports/index.blade.php ENDPATH**/ ?>
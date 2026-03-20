<?php $__env->startSection('title','Transactions'); ?>
<?php $__env->startSection('page-title','Transactions'); ?>

<?php $__env->startSection('topbar-actions'); ?>
<a href="<?php echo e(route('expenses.create')); ?>" class="btn btn-primary btn-sm">
  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
  Add Transaction
</a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<div class="stats-grid" style="grid-template-columns:repeat(3,1fr)">
  <div class="stat-card">
    <div class="stat-icon-wrap red">💸</div>
    <div class="stat-body">
      <div class="stat-label">This Month Expense</div>
      <div class="stat-value expense-val">₹<?php echo e(number_format($totalExpense,2)); ?></div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon-wrap green">💰</div>
    <div class="stat-body">
      <div class="stat-label">This Month Income</div>
      <div class="stat-value income-val">₹<?php echo e(number_format($totalIncome,2)); ?></div>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon-wrap <?php echo e($balance >= 0 ? 'blue' : 'amber'); ?>">⚖️</div>
    <div class="stat-body">
      <div class="stat-label">Net Balance</div>
      <div class="stat-value" style="color:<?php echo e($balance >= 0 ? 'var(--income)' : 'var(--expense)'); ?>">
        <?php echo e($balance >= 0 ? '+' : ''); ?>₹<?php echo e(number_format(abs($balance),2)); ?>

      </div>
    </div>
  </div>
</div>

<form method="GET" action="<?php echo e(route('expenses.index')); ?>" class="filters-bar">
  <div class="search-bar">
    <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
    <input class="form-control" type="search" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search transactions…">
  </div>
  <select class="form-select" name="type" onchange="this.form.submit()" style="width:120px">
    <option value="">All Types</option>
    <option value="expense" <?php if(request('type')==='expense'): echo 'selected'; endif; ?>>Expense</option>
    <option value="income"  <?php if(request('type')==='income'): echo 'selected'; endif; ?>>Income</option>
  </select>
  <select class="form-select" name="category" onchange="this.form.submit()" style="width:150px">
    <option value="">All Categories</option>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($cat->id); ?>" <?php if(request('category')==$cat->id): echo 'selected'; endif; ?>><?php echo e($cat->icon); ?> <?php echo e($cat->name); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
  <select class="form-select" name="payment_method" onchange="this.form.submit()" style="width:140px">
    <option value="">All Methods</option>
    <?php $__currentLoopData = $paymentMethods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pm): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($pm); ?>" <?php if(request('payment_method')===$pm): echo 'selected'; endif; ?>><?php echo e($pm); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
  <input class="form-control" type="date" name="date_from" value="<?php echo e(request('date_from')); ?>" style="width:150px" onchange="this.form.submit()">
  <input class="form-control" type="date" name="date_to"   value="<?php echo e(request('date_to')); ?>"   style="width:150px" onchange="this.form.submit()">
  <button class="btn btn-outline btn-sm" type="submit">Filter</button>
  <?php if(request()->anyFilled(['search','type','category','payment_method','date_from','date_to'])): ?>
    <a href="<?php echo e(route('expenses.index')); ?>" class="btn btn-ghost btn-sm">Clear</a>
  <?php endif; ?>
</form>

<div class="card">
  <div class="card-header">
    <div class="card-title">All Transactions
      <span style="font-size:12px;font-weight:400;color:var(--muted);margin-left:8px"><?php echo e($expenses->total()); ?> records</span>
    </div>
  </div>
  <div class="table-wrap">
    <?php if($expenses->isEmpty()): ?>
      <div class="empty-state">
        <div class="empty-state-icon">💸</div>
        <h3>No transactions found</h3>
        <p><a href="<?php echo e(route('expenses.create')); ?>" style="color:var(--primary)">Add your first transaction</a></p>
      </div>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>Title</th><th>Type</th><th>Category</th>
          <th>Date</th><th>Method</th><th>Amount</th><th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exp): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td>
            <div style="font-weight:600"><?php echo e(e($exp->title)); ?></div>
            <?php if($exp->description): ?><div style="font-size:12px;color:var(--muted)"><?php echo e(Str::limit($exp->description,45)); ?></div><?php endif; ?>
            <?php if($exp->is_recurring): ?><span class="badge badge-blue" style="font-size:10px;margin-top:3px">🔄 Recurring</span><?php endif; ?>
          </td>
          <td><span class="badge badge-<?php echo e($exp->type === 'income' ? 'income' : 'expense'); ?>"><?php echo e(ucfirst($exp->type)); ?></span></td>
          <td>
            <div style="display:flex;align-items:center;gap:6px">
              <span><?php echo e($exp->category?->icon); ?></span>
              <span style="font-size:13px"><?php echo e($exp->category?->name); ?></span>
            </div>
          </td>
          <td style="color:var(--muted);font-size:13px;white-space:nowrap"><?php echo e($exp->date->format('d M Y')); ?></td>
          <td><span class="badge badge-gray"><?php echo e($exp->payment_method); ?></span></td>
          <td style="white-space:nowrap">
            <span class="<?php echo e($exp->type === 'income' ? 'amount-income' : 'amount-expense'); ?>">
              <?php echo e($exp->type === 'income' ? '+' : '-'); ?>₹<?php echo e(number_format($exp->amount,2)); ?>

            </span>
          </td>
          <td>
            <div class="action-strip">
              <a href="<?php echo e(route('expenses.show', $exp)); ?>" class="btn-icon" title="View">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              </a>
              <a href="<?php echo e(route('expenses.edit', $exp)); ?>" class="btn-icon" title="Edit">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
              </a>
              <form method="POST" action="<?php echo e(route('expenses.destroy', $exp)); ?>" id="del-<?php echo e($exp->id); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                <button type="button" class="btn-icon danger" onclick="confirmDelete(document.getElementById('del-<?php echo e($exp->id); ?>'),'<?php echo e(e($exp->title)); ?>')">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                </button>
              </form>
            </div>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>

    <?php if($expenses->hasPages()): ?>
    <div class="pagination-wrap">
      <div class="pagination-info">Showing <?php echo e($expenses->firstItem()); ?>–<?php echo e($expenses->lastItem()); ?> of <?php echo e($expenses->total()); ?></div>
      <div class="pagination-links">
        <?php if($expenses->onFirstPage()): ?>
          <span class="page-link disabled">‹</span>
        <?php else: ?>
          <a class="page-link" href="<?php echo e($expenses->previousPageUrl()); ?>">‹</a>
        <?php endif; ?>
        <?php $__currentLoopData = $expenses->getUrlRange(max(1,$expenses->currentPage()-2), min($expenses->lastPage(),$expenses->currentPage()+2)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <a class="page-link <?php echo e($page == $expenses->currentPage() ? 'active' : ''); ?>" href="<?php echo e($url); ?>"><?php echo e($page); ?></a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php if($expenses->hasMorePages()): ?>
          <a class="page-link" href="<?php echo e($expenses->nextPageUrl()); ?>">›</a>
        <?php else: ?>
          <span class="page-link disabled">›</span>
        <?php endif; ?>
      </div>
    </div>
    <?php endif; ?>
    <?php endif; ?>
  </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\expensetracker\resources\views/expenses/index.blade.php ENDPATH**/ ?>
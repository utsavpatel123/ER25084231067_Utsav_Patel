<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
<title><?php echo $__env->yieldContent('title','Dashboard'); ?> — ExpenseTracker</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
</head>
<body>
<div class="layout">

  <!-- SIDEBAR -->
  <aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">
      <div class="brand-icon">💸</div>
      <span class="brand-name">ExpenseTracker</span>
    </div>
    <nav class="sidebar-nav">
      <div class="nav-group-label">Overview</div>
      <a href="<?php echo e(route('dashboard')); ?>" class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
        Dashboard
      </a>
      <div class="nav-group-label" style="margin-top:12px">Transactions</div>
      <a href="<?php echo e(route('expenses.index')); ?>" class="nav-link <?php echo e(request()->routeIs('expenses.*') ? 'active' : ''); ?>">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        Transactions
      </a>
      <a href="<?php echo e(route('expenses.create')); ?>" class="nav-link <?php echo e(request()->is('expenses/create') ? 'active' : ''); ?>">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
        Add Transaction
      </a>
      <div class="nav-group-label" style="margin-top:12px">Manage</div>
      <a href="<?php echo e(route('categories.index')); ?>" class="nav-link <?php echo e(request()->routeIs('categories.*') ? 'active' : ''); ?>">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
        Categories
      </a>
      <a href="<?php echo e(route('budgets.index')); ?>" class="nav-link <?php echo e(request()->routeIs('budgets.*') ? 'active' : ''); ?>">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 20h.01M7 20v-4"/><path d="M12 20V10"/><path d="M17 20V4"/><path d="M22 20h.01"/></svg>
        Budgets
      </a>
      <a href="<?php echo e(route('reports.index')); ?>" class="nav-link <?php echo e(request()->routeIs('reports.*') ? 'active' : ''); ?>">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
        Reports
      </a>
    </nav>
    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="user-avatar"><?php echo e(strtoupper(substr(session('admin_username','A'),0,1))); ?></div>
        <div style="flex:1;min-width:0">
          <div class="user-name"><?php echo e(session('admin_name','Administrator')); ?></div>
          <div class="user-role"><?php echo e(session('admin_username')); ?></div>
        </div>
        <form method="POST" action="<?php echo e(route('auth.logout')); ?>">
          <?php echo csrf_field(); ?>
          <button type="submit" class="btn-icon" title="Sign out">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
          </button>
        </form>
      </div>
    </div>
  </aside>

  <!-- MAIN -->
  <div class="main-wrap">
    <header class="topbar">
      <button class="menu-toggle" onclick="document.getElementById('sidebar').classList.toggle('open')">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
      </button>
      <div class="topbar-title"><?php echo $__env->yieldContent('page-title','Dashboard'); ?></div>
      <div class="topbar-right">
        <div class="topbar-date"><?php echo e(now()->format('D, d M Y')); ?></div>
        <?php echo $__env->yieldContent('topbar-actions'); ?>
      </div>
    </header>

    <!-- Flash messages -->
    <div class="flash-zone" aria-live="polite">
      <?php $__currentLoopData = ['success','error','info','warning']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(session($type)): ?>
          <div class="alert alert-<?php echo e($type); ?>" role="alert">
            <span class="alert-text"><?php echo e(session($type)); ?></span>
            <button class="alert-close" onclick="this.closest('[role=alert]').remove()">✕</button>
          </div>
        <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php if($errors->any() && !$errors->has('password')): ?>
        <div class="alert alert-error" role="alert">
          <span class="alert-text">
            Please fix the errors below:
            <ul style="margin:4px 0 0 16px;font-size:12.5px">
              <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $e): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($e); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          </span>
          <button class="alert-close" onclick="this.closest('[role=alert]').remove()">✕</button>
        </div>
      <?php endif; ?>
    </div>

    <main class="page-content"><?php echo $__env->yieldContent('content'); ?></main>

    <footer class="app-footer">
      <span>ExpenseTracker</span><span>·</span>
      <span><?php echo e(now()->year); ?></span><span>·</span>
      <span>v1.0</span>
    </footer>
  </div>
</div>
<div class="sidebar-overlay" id="sidebarOverlay"></div>
<script src="<?php echo e(asset('js/app.js')); ?>"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\xampp\htdocs\expensetracker\resources\views/layouts/app.blade.php ENDPATH**/ ?>
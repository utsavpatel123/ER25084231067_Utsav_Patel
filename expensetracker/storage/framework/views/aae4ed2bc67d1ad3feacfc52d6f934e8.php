<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>404 — Page Not Found · ExpenseTracker</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
<style>
  .error-page { min-height:100vh; display:flex; align-items:center; justify-content:center; background:var(--bg); }
  .error-card { background:var(--white); border:1px solid var(--border); border-radius:16px; padding:56px 48px; text-align:center; max-width:480px; box-shadow:0 4px 24px rgba(0,0,0,0.06); }
  .error-code { font-size:80px; font-weight:800; color:var(--border2); line-height:1; margin-bottom:8px; }
  .error-title { font-size:22px; font-weight:700; color:var(--text); margin-bottom:10px; }
  .error-msg   { font-size:14px; color:var(--muted); line-height:1.6; margin-bottom:28px; }
</style>
</head>
<body>
<div class="error-page">
  <div class="error-card">
    <div class="error-code">404</div>
    <div class="error-title">Page Not Found</div>
    <div class="error-msg"><?php echo e($message ?? 'The page you are looking for does not exist or has been moved.'); ?></div>
    <div style="display:flex;gap:10px;justify-content:center">
      <a href="<?php echo e(url()->previous() !== url()->current() ? url()->previous() : route('dashboard')); ?>" class="btn btn-outline">
        ← Go Back
      </a>
      <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-primary">
        Go to Dashboard
      </a>
    </div>
  </div>
</div>
</body>
</html>
<?php /**PATH E:\25084231020_Ashish\expensetracker\resources\views/errors/404.blade.php ENDPATH**/ ?>
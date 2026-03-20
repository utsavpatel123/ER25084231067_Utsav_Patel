<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>500 — Server Error · ExpenseTracker</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<style>
  .error-page { min-height:100vh; display:flex; align-items:center; justify-content:center; background:var(--bg); }
  .error-card { background:var(--white); border:1px solid var(--border); border-radius:16px; padding:56px 48px; text-align:center; max-width:480px; box-shadow:0 4px 24px rgba(0,0,0,0.06); }
  .error-code { font-size:80px; font-weight:800; color:var(--danger-l); line-height:1; margin-bottom:8px; letter-spacing:-2px; }
  .error-title { font-size:22px; font-weight:700; color:var(--text); margin-bottom:10px; }
  .error-msg   { font-size:14px; color:var(--muted); line-height:1.6; margin-bottom:28px; }
</style>
</head>
<body>
<div class="error-page">
  <div class="error-card">
    <div class="error-code">500</div>
    <div class="error-title">Server Error</div>
    <div class="error-msg">{{ $message ?? 'Something went wrong on our end. Please try again or contact support.' }}</div>
    <div style="display:flex;gap:10px;justify-content:center">
      <a href="{{ route('dashboard') }}" class="btn btn-primary">Go to Dashboard</a>
    </div>
    @if(config('app.debug'))
      <div style="margin-top:24px;text-align:left;background:var(--bg);border-radius:8px;padding:14px;font-size:12px;color:var(--muted);font-family:monospace">
        <strong>Debug mode is ON.</strong> Check Laravel logs for details.
      </div>
    @endif
  </div>
</div>
</body>
</html>

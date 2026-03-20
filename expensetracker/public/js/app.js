// ExpenseTracker — Main JS
function csrfToken() { return document.querySelector('meta[name="csrf-token"]')?.content ?? ''; }
function switchTab(btn, paneId) {
  btn.closest('[data-tabs]')?.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
  btn.closest('[data-tabs]')?.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
  btn.classList.add('active');
  document.getElementById(paneId)?.classList.add('active');
}
function confirmDelete(form, name) {
  if (confirm('Delete "' + name + '"?\nThis action cannot be undone.')) form.submit();
}
document.querySelectorAll('.flash-zone [role="alert"]').forEach(el => {
  setTimeout(() => { el.style.transition='opacity .4s'; el.style.opacity='0'; setTimeout(()=>el.remove(),420); }, 5000);
});
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebarOverlay');
if (overlay) overlay.addEventListener('click', () => sidebar?.classList.remove('open'));
document.addEventListener('keydown', e => { if (e.key==='Escape') sidebar?.classList.remove('open'); });
document.querySelectorAll('form[novalidate]').forEach(form => {
  form.addEventListener('submit', e => {
    let first = null;
    form.querySelectorAll('[required]').forEach(f => {
      if (!f.value.trim()) { f.classList.add('is-invalid'); if (!first) first = f; }
      else f.classList.remove('is-invalid');
    });
    if (first) { e.preventDefault(); first.focus(); first.scrollIntoView({behavior:'smooth',block:'center'}); }
  });
  form.querySelectorAll('.form-control,.form-select').forEach(f => {
    f.addEventListener('input', () => f.classList.remove('is-invalid'));
  });
});
// Recurring period toggle
const recurringCheck = document.getElementById('is_recurring');
const recurringPeriod = document.getElementById('recurring_period_wrap');
if (recurringCheck && recurringPeriod) {
  const toggle = () => { recurringPeriod.style.display = recurringCheck.checked ? '' : 'none'; };
  toggle(); recurringCheck.addEventListener('change', toggle);
}

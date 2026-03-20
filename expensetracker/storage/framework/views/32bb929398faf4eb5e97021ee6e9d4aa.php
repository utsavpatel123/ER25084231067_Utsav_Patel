<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['type' => 'success', 'dismissible' => true]));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['type' => 'success', 'dismissible' => true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
$classes = [
    'success' => 'alert-success',
    'error'   => 'alert-error',
    'warning' => 'alert-warning',
    'info'    => 'alert-info',
];
$class = $classes[$type] ?? 'alert-info';
?>

<div class="alert <?php echo e($class); ?>" role="alert">
    <span class="alert-text"><?php echo e($slot); ?></span>
    <?php if($dismissible): ?>
        <button class="alert-close" onclick="this.closest('[role=alert]').remove()">✕</button>
    <?php endif; ?>
</div>
<?php /**PATH D:\xampp\htdocs\expensetracker\resources\views/components/alert.blade.php ENDPATH**/ ?>
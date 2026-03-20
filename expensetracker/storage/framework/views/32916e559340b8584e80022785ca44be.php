<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'label'    => '',
    'name'     => '',
    'required' => false,
    'hint'     => '',
    'full'     => false,
]));

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

foreach (array_filter(([
    'label'    => '',
    'name'     => '',
    'required' => false,
    'hint'     => '',
    'full'     => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="form-group <?php echo e($full ? 'full' : ''); ?>">
    <?php if($label): ?>
        <label class="form-label" for="<?php echo e($name); ?>">
            <?php echo e($label); ?>

            <?php if($required): ?> <span class="req">*</span> <?php endif; ?>
        </label>
    <?php endif; ?>

    <?php echo e($slot); ?>


    <?php if($hint): ?>
        <div class="form-hint"><?php echo e($hint); ?></div>
    <?php endif; ?>

    <?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
        <div class="form-error"><?php echo e($message); ?></div>
    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<?php /**PATH C:\xampp\htdocs\expensetracker\resources\views/components/form-group.blade.php ENDPATH**/ ?>
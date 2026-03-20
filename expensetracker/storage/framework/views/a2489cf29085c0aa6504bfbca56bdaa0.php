<div class="form-group" style="margin-bottom:12px">
  <label class="form-label">Budget Name <span class="req">*</span></label>
  <input class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="name" value="<?php echo e(old('name', $b?->name)); ?>" placeholder="e.g. Food Budget" required>
  <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<div class="form-group" style="margin-bottom:12px">
  <label class="form-label">Category (optional)</label>
  <select class="form-select" name="category_id">
    <option value="">All Categories</option>
    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($cat->id); ?>" <?php if(old('category_id', $b?->category_id) == $cat->id): echo 'selected'; endif; ?>><?php echo e($cat->icon); ?> <?php echo e($cat->name); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
</div>
<div class="form-group" style="margin-bottom:12px">
  <label class="form-label">Budget Amount (₹) <span class="req">*</span></label>
  <input class="form-control <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="number" name="amount" value="<?php echo e(old('amount', $b?->amount)); ?>" placeholder="5000" step="0.01" min="1" required>
  <?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
</div>
<div class="form-grid" style="margin-bottom:12px">
  <div class="form-group">
    <label class="form-label">Period <span class="req">*</span></label>
    <select class="form-select" name="period" required>
      <?php $__currentLoopData = ['weekly'=>'Weekly','monthly'=>'Monthly','yearly'=>'Yearly']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val => $lbl): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($val); ?>" <?php if(old('period', $b?->period ?? 'monthly') === $val): echo 'selected'; endif; ?>><?php echo e($lbl); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
  </div>
  <div class="form-group">
    <label class="form-label">Year <span class="req">*</span></label>
    <select class="form-select" name="period_year" required>
      <?php $__currentLoopData = $years; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $y): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($y); ?>" <?php if(old('period_year', $b?->period_year ?? now()->year) == $y): echo 'selected'; endif; ?>><?php echo e($y); ?></option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
  </div>
</div>
<div class="form-group" style="margin-bottom:12px">
  <label class="form-label">Month</label>
  <select class="form-select" name="period_month">
    <option value="">All Months</option>
    <?php $__currentLoopData = $months; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $num => $name): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <option value="<?php echo e($num); ?>" <?php if(old('period_month', $b?->period_month) == $num): echo 'selected'; endif; ?>><?php echo e($name); ?></option>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </select>
</div>
<?php $__errorArgs = ['amount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
<?php /**PATH C:\xampp\htdocs\expensetracker\resources\views/budgets/_form.blade.php ENDPATH**/ ?>
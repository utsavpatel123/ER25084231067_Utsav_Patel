<?php $__env->startSection('title','Categories'); ?>
<?php $__env->startSection('page-title','Categories'); ?>

<?php $__env->startSection('content'); ?>

<div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start">

  
  <div class="card">
    <div class="card-header"><div class="card-title">All Categories <span style="font-size:12px;font-weight:400;color:var(--muted);margin-left:6px"><?php echo e($categories->count()); ?> total</span></div></div>
    <div class="table-wrap">
      <?php if($categories->isEmpty()): ?>
        <div class="empty-state"><div class="empty-state-icon">🏷️</div><h3>No categories yet</h3><p>Add your first category on the right.</p></div>
      <?php else: ?>
      <table>
        <thead><tr><th>Category</th><th>Type</th><th>Transactions</th><th>Total Spent</th><th>Actions</th></tr></thead>
        <tbody>
          <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
            <td>
              <div style="display:flex;align-items:center;gap:10px">
                <div style="width:36px;height:36px;border-radius:8px;background:<?php echo e($cat->color); ?>20;display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0"><?php echo e($cat->icon); ?></div>
                <div>
                  <div style="font-weight:600"><?php echo e(e($cat->name)); ?></div>
                  <div style="width:10px;height:10px;border-radius:50%;background:<?php echo e($cat->color); ?>;display:inline-block;margin-top:3px"></div>
                </div>
              </div>
            </td>
            <td>
              <?php if($cat->type === 'expense'): ?> <span class="badge badge-expense">Expense</span>
              <?php elseif($cat->type === 'income'): ?> <span class="badge badge-income">Income</span>
              <?php else: ?> <span class="badge badge-blue">Both</span>
              <?php endif; ?>
            </td>
            <td style="color:var(--text2)"><?php echo e($cat->expenses_count); ?></td>
            <td class="amount-expense"><?php if($cat->total_spent): ?> ₹<?php echo e(number_format($cat->total_spent,2)); ?> <?php else: ?> — <?php endif; ?></td>
            <td>
              <div class="action-strip">
                
                <button type="button" class="btn-icon" title="Edit"
                  onclick="openEditCat(<?php echo e($cat->id); ?>,'<?php echo e(e($cat->name)); ?>','<?php echo e($cat->icon); ?>','<?php echo e($cat->color); ?>','<?php echo e($cat->type); ?>')">
                  <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                </button>
                <?php if(!$cat->is_default): ?>
                <form method="POST" action="<?php echo e(route('categories.destroy', $cat)); ?>" id="cat-del-<?php echo e($cat->id); ?>">
                  <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                  <button type="button" class="btn-icon danger"
                    onclick="confirmDelete(document.getElementById('cat-del-<?php echo e($cat->id); ?>'),'<?php echo e(e($cat->name)); ?>')">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                  </button>
                </form>
                <?php endif; ?>
              </div>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
      </table>
      <?php endif; ?>
    </div>
  </div>

  
  <div>
    <div class="card" id="cat-form-card">
      <div class="card-header"><div class="card-title" id="cat-form-title">Add Category</div></div>
      <div class="card-body">
        <form method="POST" action="<?php echo e(route('categories.store')); ?>" novalidate id="cat-add-form">
          <?php echo csrf_field(); ?>
          <div class="form-group" style="margin-bottom:14px">
            <label class="form-label">Name <span class="req">*</span></label>
            <input class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" type="text" name="name" value="<?php echo e(old('name')); ?>" placeholder="e.g. Travel" required>
            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
          </div>
          <div class="form-grid" style="margin-bottom:14px">
            <div class="form-group">
              <label class="form-label">Icon (emoji) <span class="req">*</span></label>
              <input class="form-control" type="text" name="icon" value="<?php echo e(old('icon','💰')); ?>" maxlength="5" placeholder="💰" required>
            </div>
            <div class="form-group">
              <label class="form-label">Color <span class="req">*</span></label>
              <input class="form-control" type="color" name="color" value="<?php echo e(old('color','#4361ee')); ?>" style="height:42px;padding:4px" required>
            </div>
          </div>
          <div class="form-group" style="margin-bottom:20px">
            <label class="form-label">Type <span class="req">*</span></label>
            <select class="form-select" name="type" required>
              <option value="expense" <?php if(old('type','expense')==='expense'): echo 'selected'; endif; ?>>Expense</option>
              <option value="income"  <?php if(old('type')==='income'): echo 'selected'; endif; ?>>Income</option>
              <option value="both"    <?php if(old('type')==='both'): echo 'selected'; endif; ?>>Both</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add Category
          </button>
        </form>

        
        <form method="POST" id="cat-edit-form" style="display:none">
          <?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
          <div class="form-group" style="margin-bottom:14px">
            <label class="form-label">Name <span class="req">*</span></label>
            <input class="form-control" type="text" id="edit-name" name="name" required>
          </div>
          <div class="form-grid" style="margin-bottom:14px">
            <div class="form-group">
              <label class="form-label">Icon</label>
              <input class="form-control" type="text" id="edit-icon" name="icon" maxlength="5">
            </div>
            <div class="form-group">
              <label class="form-label">Color</label>
              <input class="form-control" type="color" id="edit-color" name="color" style="height:42px;padding:4px">
            </div>
          </div>
          <div class="form-group" style="margin-bottom:20px">
            <label class="form-label">Type</label>
            <select class="form-select" id="edit-type" name="type">
              <option value="expense">Expense</option>
              <option value="income">Income</option>
              <option value="both">Both</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary" style="width:100%">Save Changes</button>
          <button type="button" class="btn btn-outline" style="width:100%;margin-top:8px" onclick="cancelEdit()">Cancel</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php $__env->startPush('scripts'); ?>
<script>
function openEditCat(id, name, icon, color, type) {
  document.getElementById('cat-form-title').textContent = 'Edit Category';
  document.getElementById('cat-add-form').style.display = 'none';
  const form = document.getElementById('cat-edit-form');
  form.action = '/categories/' + id;
  form.style.display = '';
  document.getElementById('edit-name').value  = name;
  document.getElementById('edit-icon').value  = icon;
  document.getElementById('edit-color').value = color;
  document.getElementById('edit-type').value  = type;
}
function cancelEdit() {
  document.getElementById('cat-form-title').textContent = 'Add Category';
  document.getElementById('cat-add-form').style.display = '';
  document.getElementById('cat-edit-form').style.display = 'none';
}
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH E:\25084231020_Ashish\expensetracker\resources\views/categories/index.blade.php ENDPATH**/ ?>
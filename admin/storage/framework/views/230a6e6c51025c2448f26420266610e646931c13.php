<?php $__env->startSection('contenido'); ?>
    <unity root="<?php echo e($root); ?>"></unity>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
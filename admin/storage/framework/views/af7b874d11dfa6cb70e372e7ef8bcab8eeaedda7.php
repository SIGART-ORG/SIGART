<?php $__env->startSection('contenido'); ?>
<pages module="<?php echo e($module); ?>"></pages>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
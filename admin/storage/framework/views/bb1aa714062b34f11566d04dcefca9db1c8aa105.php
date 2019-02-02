<?php $__env->startSection('contenido'); ?>
    <modules @update_side_bar="update_side_bar"></modules>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('main', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
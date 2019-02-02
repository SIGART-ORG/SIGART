
<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="main.html"><i class="icon-speedometer"></i> Escritorio</a>
            </li>
            <li class="nav-title">
                Mantenimiento
            </li>
            <?php $__currentLoopData = $sidebar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $modulo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="nav-item nav-dropdown">
                <a class="nav-link nav-dropdown-toggle" href="#">
                    <i class="<?php echo e($modulo['icon']); ?>"></i> <?php echo e($modulo['name']); ?>

                </a>
                <ul class="nav-dropdown-items">
                    <?php $__currentLoopData = $modulo['pages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pages): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($pages['view_panel'] == 1): ?>
                    <li class="nav-item" @click="redirect_page('<?php echo e($pages['url']); ?>/dashboard')">
                        <a class="nav-link" :class="{'active': menu==<?php echo e($pages['id']); ?> }">
                            <i class="icon-bag"></i> <?php echo e($pages['name']); ?>

                        </a>
                    </li>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
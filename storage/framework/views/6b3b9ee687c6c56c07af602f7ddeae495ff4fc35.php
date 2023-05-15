
<?php $__env->startSection('title', 'Tentativa'); ?>
<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
        <div class="app"></div>
         <?php $__env->slot('header', null, []); ?> 
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a id="voltar" href="<?php echo e(url()->previous()); ?>" class="btn btn-secondary mr-2">Voltar</a>
                <?php echo e(__('Tentativa')); ?>

            </h2>
         <?php $__env->endSlot(); ?>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="d-flex mb-2">
                    <form method="POST" action="<?php echo e(route('excel.export')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="submit" value="Exportar Excel" class="btn btn-sm-hlink">
                    </form>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="rowCatGeral mt-4">
                                <div class="btn btn-Cathlink resultCategoriasDisplay px-3">
                                    <?php echo e($categoria->categoria); ?><span
                                        class="text-right resultMediaDisplay"><?php echo e($categoria->media); ?></span>
                                </div>
                            </div>
                            <?php
                                $count = 0;
                                $categs = $categoria->Respondidas
                            ?>
                            <?php $__currentLoopData = $categs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $respondidas): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="ps-3 mb-2">



                                    <?php if($key == 0): ?>
                                        <div class="color-hlink tituloPergunta"><?php echo e($respondidas->pergunta); ?></div>
                                        <?php if($respondidas->pontos == null): ?>
                                            <div><?php echo e($respondidas->resposta); ?></div>
                                        <?php else: ?>
                                            <div><?php echo e($respondidas->resposta); ?> <span
                                                    class="badge rounded-pill bg-info"><?php echo e($respondidas->pontos); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    <?php elseif($categs[$key]->pergunta == $categs[$key - 1]->pergunta): ?>
                                        <div><?php echo e($respondidas->resposta); ?></div>
                                    <?php else: ?>
                                        <div class="color-hlink tituloPergunta"><?php echo e($respondidas->pergunta); ?></div>
                                        <?php if($respondidas->pontos == null): ?>
                                            <div><?php echo e($respondidas->resposta); ?></div>
                                        <?php else: ?>
                                            <div><?php echo e($respondidas->resposta); ?> <span
                                                    class="badge rounded-pill bg-info"><?php echo e($respondidas->pontos); ?></span>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        <canvas class="d-flex mb-2 align-self-center" id="myChart" width="500" height="500"
                                style="max-height: 25em!important;max-width: 25em!important;">
                            </canvas>
                    </div>
                </div>
            </div>
        </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
    <script src="<?php echo e(asset('/js/respondidas.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backoffice.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projetos\cybercheckup\resources\views/backoffice/respondidas.blade.php ENDPATH**/ ?>
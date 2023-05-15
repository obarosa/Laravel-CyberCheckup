
<?php $__env->startSection('title', 'Dashboard'); ?>
<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('header', null, []); ?> 
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Dashboard')); ?>

            </h2>
         <?php $__env->endSlot(); ?>
        
        <?php if(session('status')): ?>
            <div class="alert alert-success col-6 mt-2" role="alert">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>
        <div class="alert alert-success col-9 mt-2 m-auto" role="alert" id="alertSucessoCustom" style="display: none">
        </div>
        <?php if(session('erro')): ?>
            <div class="alert alert-danger col-6 mt-2" role="alert">
                <?php echo e(session('erro')); ?>

            </div>
        <?php endif; ?>

        <div class="pt-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form action="<?php echo e(route('importar.excel')); ?>" method="POST" enctype="multipart/form-data">
                            <?php echo csrf_field(); ?>
                            <label for="formFile" class="form-label">Importar ficheiro excel:</label>
                            <div class="d-flex">
                                <div class="col-4">
                                    <input type="file" class="form-control" name="file" id="formFile" accept=".xlsx">
                                </div>
                                <button type="submit" id="btnSubmitExcel" class="btn btn-primary ms-3"
                                    style="display: none">Importar</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="pt-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <label for="exampleInputEmail1" class="form-label">Email para receber dados:</label>
                        <div class="d-flex">
                            <div class="col-4">
                                <input type="email" class="form-control" id="exampleInputEmail1"
                                    aria-describedby="emailHelp">
                            </div>
                            <button type="submit" class="btn btn-primary ms-3" id="alterarEmail">Alterar</button>
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
    <script src="<?php echo e(asset('/js/dashboard.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backoffice.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projetos\Laravel-CyberCheckup\resources\views/backoffice/dashboard.blade.php ENDPATH**/ ?>

<?php $__env->startSection('title','Tipos de Utilizador'); ?>
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
                <?php echo e(__('Tipos De Utilizador')); ?>

            </h2>
         <?php $__env->endSlot(); ?>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>
                            <a id="createTipo" class="btn btn-primary mb-4" data-bs-toggle="modal"
                               data-bs-target="#modalTipo">Criar Tipo de Utilizador</a>
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo</th>
                                <th>Ações</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($tipo->id); ?></td>
                                    <td><?php echo e($tipo->tipo); ?></td>
                                    <td style="min-width:8em!important;">
                                        <?php if($tipo->id !== 1 && $tipo->id !== 2): ?>
                                            <a id="edittipo_<?php echo e($tipo->id); ?>" class="btn btn-sm btn-success btedittipo" data-bs-toggle="modal" data-bs-target="#modalTipo"><i class="fa fa-pencil"></i></a>
                                            <a id="delete_<?php echo e($tipo->id); ?>" class="btn btn-sm btn-danger btdeletetipo"><i class="fa fa-trash-can"></i></a>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal" id="modalTipo" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="tituloModalTipo"></span> Tipo</h5>
                    </div>
                    <div class="modal-body">
                        <label id="tipoLabel" style="display:none" tipoId=""></label>
                        <label for="criarTipoNome">Nome: </label>
                        <input type="text" id="criarTipoNome" class="form-control mb-2">
                    </div>
                    <div class="modal-footer">
                        <button id="cancelarTipo" class="btn btn-secondary close" data-bs-dismiss="modal">Cancelar
                        </button>
                        <button id="btnGuardarTipo" class="btn btn-primary">Guardar</button>
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

    <script src="<?php echo e(asset('/js/tipos.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backoffice.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projetos\Laravel-CyberCheckup\resources\views/backoffice/tipos.blade.php ENDPATH**/ ?>
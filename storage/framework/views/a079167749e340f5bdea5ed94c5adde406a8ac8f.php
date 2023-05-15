
<?php $__env->startSection('title', 'Categorias'); ?>
<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('header', null, []); ?> 
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Categorias')); ?>

            </h2>
         <?php $__env->endSlot(); ?>
        
        <?php if(session('status')): ?>
            <div class="mx-auto alert alert-success col-9 mt-2" role="alert" style="margin-bottom: -35px!important;">
                <?php echo e(session('status')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('erro')): ?>
            <div class="mx-auto alert alert-danger col-9 mt-2" role="alert" style="margin-bottom: -35px!important;">
                <?php echo e(session('erro')); ?>

            </div>
        <?php endif; ?>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>
                            <a id="createCategoriaModal" class="btn btn-primary mb-4" data-bs-toggle="modal"
                               data-bs-target="#modalCategoria">Criar Categoria</a>
                        </div>
                        <div id="alertSemQuestoes" class="alert alert-warning" role="alert" style="display:none">
                            Atenção: Categorias sem Questões não serão vistas pelos utilizadores!
                        </div>
                        <table id="tableCategorias" class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nome</th>
                                    <th>Nº de Questões</th>
                                    <th>Visível</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="row_position">
                                <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $categoria): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id=<?php echo e($categoria->id); ?> class="linhaOrdemCat">
                                        <td class="text-center align-middle">
                                            <i class="fa-solid fa-bars pe-grab"><?php echo e($categoria->ordem); ?></i>
                                        </td>
                                        <td class="align-middle"><?php echo e($categoria->nome); ?></td>
                                        <td style="min-width:10em!important;" class="align-middle">
                                            <?php echo e(count($categoria->Questoes)); ?>

                                        </td>
                                        <td><?php echo e($categoria->visivel == 1 ? 'Sim' : 'Não'); ?></td>
                                        <td style="min-width:8em!important;">
                                            <a id="show_<?php echo e($categoria->id); ?>"
                                                href="<?php echo e(route('categorias.show', $categoria->id)); ?>"
                                                class="btn btn-sm btn-primary btshowcat"><i class="fa fa-eye"></i></a>
                                            <a id="editcategoria_<?php echo e($categoria->id); ?>"
                                                class="btn btn-sm btn-success bteditcat" data-bs-toggle="modal"
                                                data-bs-target="#modalCategoria"><i class="fa fa-pencil"></i></a>
                                            <a id="delete_<?php echo e($categoria->id); ?>"
                                                class="btn btn-sm btn-danger btdeletecat"><i
                                                    class="fa fa-trash-can"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        
        <div class="modal" id="modalCategoria" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="tituloModalCategoria"></span> Categoria</h5>
                    </div>
                    <div class="modal-body">
                        <label id="categoriaLabel" style="display:none" catId=""></label>
                        <label for="criarCategoriaNome">Nome: </label>
                        <input id="criarCategoriaNome" type="text" class="form-control mb-2">
                        <label for="categoriaVisivel">Visível: </label>
                        <input id="categoriaVisivel" type="checkbox" class="mb-2">
                    </div>
                    <div class="modal-footer">
                        <button id="cancelarGuardarCategoria" class="btn btn-secondary close"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button id="btnGuardarCategoria" class="btn btn-primary">Guardar</button>
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

    <script src="<?php echo e(asset('/js/categorias.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backoffice.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projetos\cybercheckup\resources\views/backoffice/categorias.blade.php ENDPATH**/ ?>
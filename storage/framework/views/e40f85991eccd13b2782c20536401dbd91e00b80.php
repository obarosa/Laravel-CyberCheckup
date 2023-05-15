
<?php $__env->startSection('title', $questao->nome); ?>
<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('header', null, []); ?> 
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a id="voltar" href="<?php echo e(route('categorias.show', $categoria->id)); ?>"
                    class="btn btn-secondary mr-2">Voltar</a>
                <?php echo e(__('Questão: ' . $questao->nome)); ?>

            </h2>
         <?php $__env->endSlot(); ?>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>
                            <a id="createRespostaModal" href="#" class="btn btn-primary mb-4" data-bs-toggle="modal"
                                data-bs-target="#modalResposta">Criar Resposta</a>
                        </div>
                        <table id="tableRespostas" class="table caption-top">
                            <caption>Lista de Respostas</caption>
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Pontuação</th>
                                    <th>Nome</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="row_position">
                                <?php $__currentLoopData = $respostas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resposta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id="<?php echo e($resposta->id); ?>" class="linhaOrdemResp">
                                        <td class="text-center align-middle">
                                            <i class="fa-solid fa-bars pe-grab"><?php echo e($resposta->ordem); ?></i>
                                        </td>
                                        <td class="align-middle"><?php echo e($resposta->pontos); ?></td>
                                        <td class="align-middle"><?php echo e($resposta->nome); ?></td>
                                        <td style="min-width:8em!important;">
                                            <a id="editresposta_<?php echo e($resposta->id); ?>"
                                                class="btn btn-sm btn-success bteditresp" data-bs-toggle="modal"
                                                data-bs-target="#modalResposta"><i class="fa fa-pencil"></i></a>
                                            <a id="deleteresposta_<?php echo e($resposta->id); ?>"
                                                class="btn btn-sm btn-danger btdeleteresp"><i
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

        
        <div class="modal" id="modalResposta" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="tituloModalResposta"></span> para a questao:
                            <?php echo e($questao->nome); ?></h5>
                    </div>
                    <div class="modal-body">
                        <label id="questaoLabel" style="display:none" questId="<?php echo e($questao->id); ?>"></label>
                        <label id="respostaLabel" style="display:none"></label>
                        <?php if($questao->pontuacao == 1): ?>
                        <label for="criarRespostaPontuacao">Pontos: </label>
                        <input id="criarRespostaPontuacao" type="number" min="0" class="form-control" value="0">
                        <?php endif; ?>
                        <label for="criarRespostaNome">Nome: </label>
                        <textarea id="criarRespostaNome" type="text" class="form-control"></textarea>
                    </div>
                    <div class="modal-footer">
                        <button id="cancelarGuardarResposta" class="btn btn-secondary close"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button id="btnGuardarResposta" class="btn btn-primary">Guardar</button>
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

    <script src="<?php echo e(asset('/js/respostas.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backoffice.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projetos\cybercheckup\resources\views/backoffice/questao-respostas.blade.php ENDPATH**/ ?>

<?php $__env->startSection('title', $categoria->nome); ?>
<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
         <?php $__env->slot('header', null, []); ?> 
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <a id="voltar" href="<?php echo e(route('categorias.index')); ?>" class="btn btn-secondary mr-2">Voltar</a>
                <?php echo e(__('Categoria: ' . $categoria->nome)); ?>

            </h2>
         <?php $__env->endSlot(); ?>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>
                            <a id="createQuestaoModal" class="btn btn-primary mb-4" data-bs-toggle="modal"
                                data-bs-target="#modalQuestao">Criar Questão</a>
                        </div>
                        <div id="alertSemRespostas" class="alert alert-warning" role="alert" style="display:none">
                            Atenção: Questões com menos de 2 Respostas não serão vistas pelos utilizadores!
                        </div>
                        <table id="tableQuestoes" class="table caption-top">
                            <caption>Lista de Questões</caption>
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Nome</th>
                                    <th>Nº de Respostas</th>
                                    <th>Obrigatória</th>
                                    <th>Multi Respostas</th>
                                    <th>Pontuação</th>
                                    <th>Info.</th>
                                    <th style="max-width: 4em!important;">Tipos</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody id="row_position">
                                <?php $__currentLoopData = $questoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $questao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr id=<?php echo e($questao->id); ?> class="linhaOrdemQuest">
                                        <td class="text-center align-middle">
                                            <i class="fa-solid fa-bars pe-grab"><?php echo e($questao->ordem); ?></i>
                                        </td>
                                        <td class="align-middle"><?php echo e($questao->nome); ?></td>
                                        <td style="min-width:6em!important;" class="align-middle"><?php echo e(count($questao->Respostas)); ?></td>
                                        <td style="min-width:6em"><?php echo e($questao->obrigatoria == 1 ? 'Sim' : 'Não'); ?></td>
                                        <td style="min-width:6em"><?php echo e($questao->multiresposta == 1 ? 'Sim' : 'Não'); ?></td>
                                        <td style="min-width:6em"><?php echo e($questao->pontuacao == 1 ? 'Sim' : 'Não'); ?></td>
                                        <td>
                                            <?php if($questao->info != null): ?>
                                                <button type="button" data-container="body" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="<?php echo e($questao->info); ?>">
                                                    <i class="fa-solid fa-info"></i>
                                                </button>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td class="tdTipos">
                                            <?php if(count($questao->Tipos) != 0): ?>
                                                <button type="button" data-container="body" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" data-bs-html="true" style=""
                                                    title=" <?php $__currentLoopData = $questao->Tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e($tipo->tipo . '<br>'); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">
                                                    <?php $__currentLoopData = $questao->Tipos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tipo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <span class="badge bg-light text-dark"><?php echo e($tipo->tipo); ?></span>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    
                                                </button>
                                            <?php else: ?>
                                                -
                                            <?php endif; ?>
                                        </td>
                                        <td style="min-width:8em!important;">
                                            <a id="showquestao_<?php echo e($questao->id); ?>"
                                                href="<?php echo e(route('questoes.show', $questao->id)); ?>"
                                                class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>
                                            <a id="editquestao_<?php echo e($questao->id); ?>"
                                                class="btn btn-sm btn-success bteditquest" data-bs-toggle="modal"
                                                data-bs-target="#modalQuestao"><i class="fa fa-pencil"></i></a>
                                            <a id="deletequestao_<?php echo e($questao->id); ?>"
                                                class="btn btn-sm btn-danger btdeletequest"><i
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

        
        <div class="modal" id="modalQuestao" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="tituloModalQuestao"></span> para a
                            categoria: <?php echo e($categoria->nome); ?></h5>
                    </div>
                    <div class="modal-body">
                        <label id="categoriaLabel" style="display:none" catId="<?php echo e($categoria->id); ?>"></label>
                        <label id="questaoLabel" style="display:none" questId=""></label>
                        <label for="criarQuestaoNome">Nome: </label>
                        <textarea id="criarQuestaoNome" type="text" class="form-control mb-2"></textarea>
                        <label for="criarQuestaoInfo">Informações Adicionais: </label>
                        <textarea id="criarQuestaoInfo" class="form-control mb-2"></textarea>
                        <label for="checkObrigatoria">Obrigatória: </label>
                        <input id="checkObrigatoria" type="checkbox" class="mb-2">
                        <label for="checkMultiresposta">Multi Resposta: </label>
                        <input id="checkMultiresposta" type="checkbox" class="mb-2">
                        <label style="margin-left: 20px;" for="checkPontuacao">Pontuação: </label>
                        <input id="checkPontuacao" type="checkbox" class="mb-2">
                        <br>
                        <label for="questaoTipos">Tipos:</label>
                        <div id="questaoTipos" class="d-flex align-items-center flex-wrap"></div>
                    </div>
                    <div class="modal-footer">
                        <button id="cancelarGuardarQuestao" class="btn btn-secondary close" data-bs-dismiss="modal">
                            Cancelar
                        </button>
                        <button id="btnGuardarQuestao" class="btn btn-primary">Guardar</button>
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

    <script src="<?php echo e(asset('/js/questoes.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backoffice.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projetos\cybercheckup\resources\views/backoffice/categoria-questoes.blade.php ENDPATH**/ ?>
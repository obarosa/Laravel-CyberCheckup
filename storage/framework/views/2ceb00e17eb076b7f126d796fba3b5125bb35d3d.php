
<?php $__env->startSection('title', 'HLink CyberCheckup'); ?>
<?php $__env->startSection('content'); ?>
    <nav class="navbar fixed-top navbar-light bg-hlink px-5" style="height: 70px;padding-left:4rem!important">
        <a href="<?php echo e(route('feHome.index')); ?>" class="btn btn-sm-hlink btnSair" type="button">Sair</a>
        <div class="d-flex align-items-center pe-5">
            <?php if(Route::has('login')): ?>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(Auth::user() && Auth::user()->isAdmin()): ?>
                        <a href="<?php echo e(url('/dashboard')); ?>" class="btn btn-sm-hlink">Dashboard</a>
                    <?php elseif(Auth::user()): ?>
                        <a href="<?php echo e(url('/perfil')); ?>" class="btn btn-sm-hlink">Perfil Utilizador</a>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('logout')); ?>" class="ps-2">
                        <?php echo csrf_field(); ?>
                        <a href="route('logout')" class="btn navLogoutIcon"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                            <i class="fa-solid fa-right-from-bracket" style="color: white"></i>
                        </a>
                    </form>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="me-2 btn btn-sm-hlink">Login</a>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </nav>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 bg-questoes-left">
                <div class="d-flex flex-column min-vh-100 justify-content-center sticky-top"
                    style="height: 100vh; width: 100%;">
                    <div class="text-center pb-5 titleHlink">Categorias</div>
                    <div class="row mx-auto resultCategoriasDisplay py-3">
                        <?php for($i = 0; $i < count($arrCateg); $i++): ?>
                            <a href="#divCategoria_<?php echo e($arrCateg[$i]->id); ?>" style="scroll-padding-top: 4rem;"
                                class="btn btn-Cathlink btnQuestoes mb-2 px-3" id="categoria_id<?php echo e($arrCateg[$i]->id); ?>"
                                id-Categ=<?php echo e($arrCateg[$i]->id); ?>>
                                <?php echo e($arrCateg[$i]->nome); ?>

                            </a>
                        <?php endfor; ?>
                    </div>
                    <div class="align-self-center pt-3 text-muted fs-6">
                        <span style="color: red">*</span>
                        Resposta Obrigatória
                    </div>
                </div>

            </div>
            <div class="col-lg-9 columnQuestoes">
                <a href="https://hlink.pt/" target="_blank">
                    <img class="float-end pe-5" src="<?php echo e(asset('assets/imgs/logo-hlink.png')); ?>" alt=""
                        style="width: 200px;">
                </a>
                <div class="d-flex mt-4 mb-4 align-items-center">
                    <div class="titleHlink me-5">Questões</div>
                </div>
                <?php for($i = 0; $i < count($arrCateg); $i++): ?>
                    <div class="rowCatGeral" id="divCategoria_<?php echo e($arrCateg[$i]->id); ?>">
                        <div class="mb-2 px-3 questoesCatNome" id="categoria_id<?php echo e($arrCateg[$i]->id); ?>">
                            <?php echo e($arrCateg[$i]->nome); ?>

                        </div>
                        <div class="linhaQuestoes"></div>
                        <?php
                            $countQuest = 1;
                            if (Auth::user()) {
                                $userTipo = Auth::user()->tipo;
                            } else {
                                $userTipo = 1;
                            }
                            $questoes = $arrCateg[$i]->Questoes;
                        ?>
                        <?php $__currentLoopData = $questoes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $questao): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $respostas = $questao->Respostas;
                                $tipoExiste = $questao->checkTipo($userTipo);
                            ?>
                            <?php if($tipoExiste): ?>
                                <?php if(count($questao->Respostas) > 1): ?>
                                    <div class="ps-3 pt-3 <?php echo e($questao->obrigatoria != 0 ? 'obgt' : ''); ?> <?php echo e($questao->multiresposta != 0 ? 'multi' : ''); ?>"
                                        id="divPerguntas" idPer="<?php echo e($questao->id); ?>">
                                        <div class="text-muted">
                                            <?php echo e(sprintf('%02d', $countQuest++)); ?>/<?php echo e($countQuestForCat[$i]); ?>

                                        </div>
                                        <div class="d-flex">
                                            <div class="color-hlink tituloPergunta pe-2"
                                                id="questao_id<?php echo e($questao->id); ?>">
                                                <?php echo e($questao->nome); ?>

                                                <?php if($questao->obrigatoria == 0): ?>
                                                <?php else: ?>
                                                    <span style="color: red">*</span>
                                                <?php endif; ?>
                                            </div>
                                            <?php if($questao->info == null): ?>
                                            <?php else: ?>
                                                <button type="button" class="btn infoTooltip" data-bs-toggle="tooltip"
                                                    data-bs-placement="top" title="<?php echo e($questao->info); ?>">
                                                    <i class="fa-solid fa-circle-question" style="color: #ada4fe;"></i>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                        <div class="mt-3 ps-4 allRespostasFromQuestion"
                                            id="opcoesResposta_id<?php echo e($questao->id); ?>">
                                            <?php $__currentLoopData = $respostas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $resposta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input resposta" type="<?php echo e(!$questao->multiresposta ? 'radio' : 'checkbox'); ?>"
                                                        value="<?php echo e($resposta->id); ?>"
                                                        name="respostas_quest<?php echo e($questao->id); ?>"
                                                        id="resposta_<?php echo e($resposta->id); ?>" />
                                                    <label class="form-check-label" for="resposta_<?php echo e($resposta->id); ?>">
                                                        <?php echo e($resposta->nome); ?>

                                                    </label>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endfor; ?>
                <div class="row py-4">
                    <span class="col-6">
                        <span class="p-3 spanSubmitQuestButton disabledBtn">
                            <form method="POST" action="<?php echo e(route('feResultado.store')); ?>">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="idsRespostas" value="" id="inputHidden">
                                <input type="submit" value="SUBMETER" class="btn btn-primary submitQuestButton disabled">
                            </form>
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo e(asset('js/questionario.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontoffice.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projetos\Laravel-CyberCheckup\resources\views/frontoffice/questoes.blade.php ENDPATH**/ ?>
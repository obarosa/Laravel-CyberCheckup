
<?php $__env->startSection('title', 'HLink CyberCheckup'); ?>
<?php $__env->startSection('content'); ?>
    <section id="esconder" class="bghide">
        <nav class="navbar fixed-top navbar-light bg-hlink px-5" style="height: 70px;padding-left:5rem!important">
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
                <div class="col-lg-8 px-5 pb-5" style="padding-top: 7rem!important;padding-left:5rem!important">
                    <a href="https://hlink.pt/" target="_blank">
                        <img class="float-end pe-5" src="<?php echo e(asset('assets/imgs/logo-hlink.png')); ?>" alt=""
                            style="width: 200px;">
                    </a>
                    <div class="d-flex mt-4 mb-4 align-items-center">
                        <div class="titleHlink me-5">Análise Detalhada</div>
                        <form method="POST" action="<?php echo e(route('pdf.create')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="submit" value="Exportar PDF" class="btn btn-sm-hlink">
                        </form>
                    </div>
                    <?php for($i = 0; $i < count($respostas); $i++): ?>
                        <div class="rowCatGeral">
                            <?php if($i == 0): ?>
                                <div class="btn btn-Cathlink resultCategoriasDisplay mb-3 px-3"
                                    id="categoria_id<?php echo e($respostas[$i]->Questao->Categoria->id); ?>">
                                    <?php echo e($respostas[$i]->Questao->Categoria->nome); ?> <span
                                        class="text-right"><?php echo e(round($pontosPorCateg[$respostas[$i]->Questao->Categoria->id], 0, PHP_ROUND_HALF_DOWN)); ?></span>
                                </div>
                            <?php elseif($respostas[$i]->Questao->Categoria->id != $respostas[$i - 1]->Questao->Categoria->id): ?>
                                <div class="btn btn-Cathlink resultCategoriasDisplay mb-3 px-3"
                                    id="categoria_id<?php echo e($respostas[$i]->Questao->Categoria->id); ?>">
                                    <?php echo e($respostas[$i]->Questao->Categoria->nome); ?> <span
                                        class="text-right"><?php echo e(round($pontosPorCateg[$respostas[$i]->Questao->Categoria->id], 0, PHP_ROUND_HALF_DOWN)); ?></span>
                                </div>
                            <?php endif; ?>
                            <?php
                                $questCount = $countQuests[$respostas[$i]->Questao->Categoria->id];

                                if ($i == 0) {
                                    $count = 0;
                                } elseif ($respostas[$i]->Questao->Categoria->id != $respostas[$i - 1]->Questao->Categoria->id) {
                                    $count = 0;
                                }
                            ?>
                            <?php if(!$respostas[$i]->Questao->multiresposta): ?>
                                <div class="ps-3">
                                    <div class="text-muted contagemPerguntas">
                                        <?php echo e(sprintf('%02d', $count += 1)); ?>/<?php echo e(sprintf('%02d', $questCount)); ?></div>
                                    <div class="color-hlink tituloPergunta"><?php echo e($respostas[$i]->Questao->nome); ?></div>
                                    <div><?php echo e($respostas[$i]->nome); ?></div>
                                </div>
                            <?php else: ?>
                                <div class="ps-3">
                                    <div class="text-muted contagemPerguntas">
                                        <?php if($i == 0): ?>
                                            <?php echo e(sprintf('%02d', $count += 1)); ?>/<?php echo e(sprintf('%02d', $questCount)); ?>

                                    </div>
                                    <div class="color-hlink tituloPergunta">
                                        <?php echo e($respostas[$i]->Questao->nome); ?>

                                    </div>
                                <?php elseif($respostas[$i]->Questao->id != $respostas[$i - 1]->Questao->id): ?>
                                    <?php echo e(sprintf('%02d', $count += 1)); ?>/<?php echo e(sprintf('%02d', $questCount)); ?>

                                </div>
                                <div class="color-hlink tituloPergunta"><?php echo e($respostas[$i]->Questao->nome); ?></div>
                            <?php else: ?>
                        </div>
                    <?php endif; ?>
                    <div><?php echo e($respostas[$i]->nome); ?></div>
                </div>
                <?php endif; ?>
            </div>
            <?php endfor; ?>
        </div>

        
        <div class="col-lg-4 bg-resultados-right" style="margin-top: 4em!important;">
            <div class="d-flex flex-column justify-content-center sticky-top overflow-auto"
                style=" height: 100vh; width: 100%;">
                <div class="text-center pb-3 titleHlink">Resultados</div>
                <div class="d-flex justify-content-center">
                    <canvas class="mb-2" id="myChart" style="max-height: 25em!important;max-width: 25em!important;">
                    </canvas>
                </div>
                <div class="row mx-auto resultCategoriasDisplay py-3">
                    <?php for($i = 0; $i < count($respostas); $i++): ?>
                        <?php if($i == 0): ?>
                            <a href="#categoria_id<?php echo e($respostas[$i]->Questao->Categoria->id); ?>"
                                class="btn btn-Cathlink mb-2 px-3" style="cursor: pointer">
                                <?php echo e($respostas[$i]->Questao->Categoria->nome); ?> <span
                                    class="text-right"><?php echo e(round($pontosPorCateg[$respostas[$i]->Questao->Categoria->id], 0, PHP_ROUND_HALF_DOWN)); ?></span>
                            </a>
                        <?php elseif($respostas[$i]->Questao->Categoria->id != $respostas[$i - 1]->Questao->Categoria->id): ?>
                            <a href="#categoria_id<?php echo e($respostas[$i]->Questao->Categoria->id); ?>"
                                class="btn btn-Cathlink mb-2 px-3" style="cursor: pointer">
                                <?php echo e($respostas[$i]->Questao->Categoria->nome); ?> <span
                                    class="text-right"><?php echo e(round($pontosPorCateg[$respostas[$i]->Questao->Categoria->id], 0, PHP_ROUND_HALF_DOWN)); ?></span>
                            </a>
                        <?php endif; ?>
                    <?php endfor; ?>
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>

    
    <div class="modal" data-bs-backdrop="static" data-bs-keyboard="false" id="modalSubmeter" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Por favor preencha os seguintes campos para poder ver os seus resultados</h5>
                </div>
                <div class="modal-body">
                    <label for="guestName">Primeiro Nome e Apelido:<span style="color: red">*</span></label>
                    <input id="guestName" type="text" class="form-control">
                    <label for="guestContacto" class="mt-2">Contacto: </label>
                    <input id="guestContacto" type="number" class="form-control">
                    <label for="guestEmail" class="mt-2">Email:<span style="color: red">*</span></label>
                    <input id="guestEmail" type="email" class="form-control">
                    <div class="mt-2"><span style="color: red">*</span><span class="text-muted fs-6">Obrigatório</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <a id="cancelarResultadoGuest" href="<?php echo e(route('feHome.index')); ?>"
                        class="btn btn-secondary close">Cancelar</a>
                    <button id="btnGuardarResultadoGuest" class="btn btn-primary">Submeter</button>
                </div>
            </div>
        </div>
    </div>

    <script src="<?php echo e(asset('js/resultado.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontoffice.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projetos\Laravel-CyberCheckup\resources\views/frontoffice/resultado.blade.php ENDPATH**/ ?>

<?php $__env->startSection('title', 'HLink CyberCheckup'); ?>
<?php $__env->startSection('content'); ?>
    <nav class="navbar fixed-top navbar-light px-5 d-flex justify-content-end"
        style="height: 70px;padding-left:5rem!important">
        <div class="align-items-center d-flex pe-5">
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
    <div class="containerHome">
        <div class="container px-2">
            <div class="d-flex flex-column justify-content-center px-5" style="min-height: 90vh!important;">
                <a href="https://hlink.pt/" target="_blank">
                    <img class="mb-3" src="<?php echo e(asset('assets/imgs/logo-hlink.png')); ?>" alt=""
                        style="width: 160px;">
                </a>
                <div class="row">
                    <div class="divTitulo">
                        <p class="fs-5 color-primary border-bottom fw-bold">AVALIAÇÃO DAS CAPACIDADES DE CIBERSEGURANÇA</p>
                    </div>
                </div>
                <div class="row">
                    <div class="divSubTitulo">
                        <p class="fw-bold fs-2">Descubra o nível em que se encontra a sua organização na implementação das
                            <a class="fst-italic text-decoration-underline color-primary"
                                href="https://www.cncs.gov.pt/docs/cncs-quadrodeavaliacao.pdf" target="_blanck">capacidades
                                de cibersegurança</a>.
                        </p>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="text-muted fs-6" style="font-weight: 500!important;">
                        SELECIONE OS OBJETIVOS DE CIBERSEGURANÇA QUE PRETENDE AVALIAR:
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="buttonContainer list-group">
                        <div class="btn-group" role="group" aria-label="">
                            <div class="d-flex align-items-center flex-wrap" style="max-width: 45em;">
                                <?php if(count($categorias) > 0): ?>
                                    <?php $__currentLoopData = $categorias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(count($value->QuestoesValidas) > 0): ?>
                                            <div class="pe-3 mt-2">
                                                <input type="checkbox" class="btn-check d-none" id="categoria_<?php echo e($value->id); ?>"
                                                    btnCheckId=<?php echo e($value->id); ?> autocomplete="off" checked>
                                                <label class="btn btn-sm btn-outline-primary botaoCat"
                                                    for="categoria_<?php echo e($value->id); ?>"
                                                    style="width: auto;min-width: 9em;"><?php echo e($value->nome); ?></label>
                                            </div>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <div class="text-muted">Não existem categorias registadas.</div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-6">
                        <span id="iniciarDisable">
                            <a type="submit" class="btn btn-primary buttonPerSuccess">
                                INICIAR AVALIAÇÃO
                            </a>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo e(asset('js/home.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontoffice.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projetos\cybercheckup\resources\views/frontoffice/home.blade.php ENDPATH**/ ?>
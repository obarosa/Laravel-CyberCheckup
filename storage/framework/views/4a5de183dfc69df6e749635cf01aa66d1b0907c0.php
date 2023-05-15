
<?php $__env->startSection('title', 'HLink CyberCheckup'); ?>
<?php $__env->startSection('content'); ?>
    <div class="container-fluid">
        <div class="row mx-auto">
            <img class="float-end pe-5 pb-4" src="<?php echo e(asset('assets/imgs/logo-hlink.png')); ?>" alt=""
                 style="width: 200px;">
            <div class="d-flex mt-4 mb-4 align-items-center">
                <div class="titleHlink ps-3">Análise Detalhada</div>
            </div>
            <?php for($i = 0; $i < count($respostas); $i++): ?>
                <div class="rowCatGeral">
                    <?php if($i == 0): ?>
                        <div class="mb-2 mt-4 questoesCatNome pdfLay">
                            <?php echo e($respostas[$i]->Questao->Categoria->nome); ?>

                            <span class="ms-3">
                                <?php echo e(floor($pontosPorCateg[$respostas[$i]->Questao->Categoria->id])); ?>


                            </span>
                        </div>
                    <?php elseif($respostas[$i]->Questao->Categoria->id != $respostas[$i - 1]->Questao->Categoria->id): ?>
                        <div class="mb-2 mt-4 questoesCatNome pdfLay">
                            <?php echo e($respostas[$i]->Questao->Categoria->nome); ?>

                            <span class="ms-3">
                                <?php echo e(floor($pontosPorCateg[$respostas[$i]->Questao->Categoria->id])); ?>

                            </span>
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
                        <div class="">
                            <div class="text-muted">
                                <?php echo e(sprintf('%02d', $count += 1)); ?>/<?php echo e(sprintf('%02d', $questCount)); ?>

                            </div>
                        </div>
                        <div class="color-hlink tituloPergunta"><?php echo e($respostas[$i]->Questao->nome); ?></div>
                        <div><?php echo e($respostas[$i]->nome); ?></div>
                    <?php else: ?>
                        <div class="">
                            <div class="text-muted">
                            <?php if($i == 0): ?>
                                    <?php echo e(sprintf('%02d', $count += 1)); ?>/<?php echo e(sprintf('%02d', $questCount)); ?>

                                </div>
                            </div>
                            <div class="color-hlink tituloPergunta"><?php echo e($respostas[$i]->Questao->nome); ?></div>
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
                </div>
            <?php endfor; ?>
        </div>
        <img class="mt-3" src=<?php echo e($pngChart); ?> alt="">
    </div>
    <script src="<?php echo e(asset('js/resultado.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('frontoffice.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projetos\cybercheckup\resources\views/pdf.blade.php ENDPATH**/ ?>
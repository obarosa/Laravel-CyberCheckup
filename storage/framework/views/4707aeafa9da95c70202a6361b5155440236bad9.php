<!DOCTYPE html>
<html>

<head>
    <title>Nova Submissão de Questionário!</title>
</head>

<body>
    <div>Foi registada uma nova submissão de questionário!</div>
    <div>Dados inseridos pelo Utilizador:</div><br>
    <div>Nome:<?php echo e($nome); ?></div>
    <div>Contacto:<?php echo e($contacto); ?></div>
    <div>Email:<?php echo e($useremail); ?></div>
    <div>Categorias:</div>
    <?php for($i = 0; $i < count($categs); $i++): ?>
        <div><?php echo e($categs[$i]); ?>

            <span>- Média:<?php echo e($medias[$i]); ?></span>
        </div>
    <?php endfor; ?>
    <div>Gráfico:</div>
    <div><img src="<?php echo e($chart); ?>" alt=""></div>
</body>

</html>
<?php /**PATH C:\Projetos\cybercheckup\resources\views/mail/submissao.blade.php ENDPATH**/ ?>
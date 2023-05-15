
<?php $__env->startSection('title', 'Utilizadores'); ?>
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
                <?php echo e(__('Utilizadores')); ?>

            </h2>
         <?php $__env->endSlot(); ?>

        
        <div class="pt-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="row">
                            <div class="col-4">
                                <a id="createUserModal" class="btn btn-primary mb-4" data-bs-toggle="modal"
                                    data-bs-target="#modalUser">Criar Utilizador</a>
                            </div>
                        </div>
                        <table id="tableUsers" class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Tipo de Utilizador</th>
                                    <th>Data</th>
                                    <th style="padding: 1.1rem !important;">Ações</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($user->name); ?></td>
                                        <td><?php echo e($user->email); ?></td>
                                        <?php if($user->tipo != null): ?>
                                            <td><?php echo e($user->Tipo->tipo); ?></td>
                                        <?php else: ?>
                                            <td>--</td>
                                        <?php endif; ?>
                                        <?php if($user->Tentativas->last() == null): ?>
                                            <td>-</td>
                                        <?php else: ?>
                                            <td><?php echo e(date('d/m/Y', strtotime($user->Tentativas->last()->created_at))); ?></td>
                                        <?php endif; ?>

                                        <td>
                                            <a id="showtentativas_<?php echo e($user->id); ?>"
                                                href="<?php echo e(route('tentativas.index', $user->id)); ?>"
                                                class="btn btn-sm btn-primary btshowtent"><i class="fa fa-eye"></i></a>
                                            <a id="edituser_<?php echo e($user->id); ?>" class="btn btn-sm btn-success btedituser"
                                                data-bs-toggle="modal" data-bs-target="#modalUser"><i
                                                    class="fa fa-pencil"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="py-5">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="row">
                            <div class="col-4">
                                <h4 class="btn btn-primary bg-gradient mb-4" style="cursor: auto!important;">
                                    Utilizadores Não Registados
                                </h4>
                            </div>
                        </div>
                        <table id="tableUsersNotAuth" class="table" width="100%">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>Telemóvel</th>
                                    <th>Data</th>
                                    <th style="padding: 1.1rem !important;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $usersNotAuth; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $userNotAuth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($userNotAuth->nome); ?></td>
                                        <td><?php echo e($userNotAuth->email); ?></td>
                                        <td><?php echo e($userNotAuth->contacto != null ? $userNotAuth->contacto : '-'); ?></td>
                                        <td><?php echo e(date('d/m/Y', strtotime($userNotAuth->created_at))); ?>

                                        </td>
                                        <td>
                                            <a id="showtentativas_<?php echo e($userNotAuth->id); ?>"
                                                href="<?php echo e(route('tentativas.show', $userNotAuth->id)); ?>"
                                                class="btn btn-sm btn-primary btshowtent">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <a id="userNotAuth_<?php echo e($userNotAuth->id); ?>"
                                                class="btn btn-sm btn-success btnUserNotAuth" data-bs-toggle="modal"
                                                data-bs-target="#modalUser">
                                                <i class="fa-solid fa-unlock-keyhole"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="modal" id="modalUser" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><span id="tituloModalUser"></span></h5>
                    </div>
                    <div class="modal-body">
                        <label id="userLabel" style="display:none" userId=""></label>
                        <label for="criarUserNome">Nome: </label>
                        <input id="criarUserNome" type="text" class="form-control mb-2">
                        <label for="criarUserEmail">Email: </label>
                        <input id="criarUserEmail" type="email" class="form-control mb-2">
                        <label id="warningpass" style="display: none"><strong>Atenção: as palavras-passe têm de
                                coincidir.</strong></label>
                        <label for="criarUserPass" id="labelPass">Password: </label>
                        <input id="criarUserPass" type="password" class="form-control mb-2">
                        <label for="userConfirmPass" id="labelConfirm">Confirmar Password: </label>
                        <input id="userConfirmPass" type="password" class="form-control mb-2">
                        <label for="selectUserTipo" id="labelTipo">Tipo: </label>
                        <div id="radios" class="form-check mb-2 d-flex"
                            style="width: 100%;flex-wrap: wrap;max-width: 25em;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button id="cancelarGuardarUser" class="btn btn-secondary close"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button id="btnGuardarUser" class="btn btn-primary">Guardar</button>
                        <button id="btnTranferirUserNotAuth" class="btn btn-primary">
                            Registar Utilizador
                        </button>
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

    <script src="<?php echo e(asset('/js/utilizadores.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('backoffice.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Projetos\Laravel-CyberCheckup\resources\views/backoffice/users.blade.php ENDPATH**/ ?>
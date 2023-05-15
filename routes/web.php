<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\TiposController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\QuestoesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RespostasController;
use App\Http\Controllers\CategoriasController;
use App\Http\Controllers\TentativasController;
use App\Http\Controllers\PerfilUtilizadorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// FRONT OFFICE
Route::controller(FrontendController::class)->group(function () {
    Route::get('/', 'indexHome')->name('feHome.index');
    Route::get('/questoes/{checados}', 'indexQuestoes')->name('feQuestoes.index');
    Route::post('/resultado', 'storeResultado')->name('feResultado.store');
    Route::get('/isguest', 'isAuth')->name('feResultado.isAuth');
    Route::post('/resultadoGuest', 'submissaoGuest')->name('feResultado.guest');
    Route::get('/resultados', 'indexResultado')->name('feResultado.index');
});

// PDF DOWNLOAD
Route::post('/pdf-create', [PdfController::class, 'create'])->name('pdf.create');

// EXCEL DOWNLOAD
Route::post('/tentativa/excel', [ExcelController::class, 'export'])->name('excel.export');

// BACK OFFICE
Route::get('/perfil', [PerfilUtilizadorController::class, 'index'])->middleware('auth')->name('utilizador.index');
Route::get('/perfil/tentativa/{id}', [PerfilUtilizadorController::class, 'getTentativa'])->middleware('auth')->name('utilizador.tentativa');

Route::group(['middleware' => 'admin'], function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    Route::post('/dashboard/importar', [DashboardController::class, 'import'])->name('importar.excel');
    Route::get('/dashboard/getemail', [DashboardController::class, 'getEmail'])->name('getEmail');
    Route::post('/dashboard/postemail', [DashboardController::class, 'postEmail'])->name('postEmail');


    Route::get('/users', [DashboardController::class, 'usersIndex'])->name('users.index');
    Route::get('/getuser/{id}', [DashboardController::class, 'getUser'])->name('users.getuser');
    Route::get('/getusernotauth/{id}', [DashboardController::class, 'getUserNotAuth'])->name('users.getusernotauth');
    Route::get('/users/getTiposUser', [DashboardController::class, 'getTiposUser'])->name('users.tipos');
    Route::post('/users/save', [DashboardController::class, 'userSave'])->name('users.save');

    Route::get('/tentativas/{id}', [TentativasController::class, 'userTentativas'])->name('tentativas.index');
    Route::get('/tentativa/{id}', [TentativasController::class, 'showTentativa'])->name('tentativas.show');

    Route::get('/tipos', [TiposController::class, 'getTipos'])->name('tipos.index');
    Route::post('/tipos/save', [TiposController::class, 'save'])->name('tipos.save');
    Route::get('/getTipo/{id}', [TiposController::class, 'getTipo'])->name('tipo.getTipo');
    Route::delete('/tipos/delete/{id}', [TiposController::class, 'delete'])->name('tipos.delete');

    Route::get('/categorias', [CategoriasController::class, 'index'])->name('categorias.index');
    Route::get('/getcategoria/{id}', [CategoriasController::class, 'getCategoria'])->name('categorias.getCategoria');
    Route::post('/categorias/order', [CategoriasController::class, 'order'])->name('categorias.order');
    Route::post('/categorias/save', [CategoriasController::class, 'save'])->name('categorias.save');
    Route::get('/categorias/show/{categoria}', [CategoriasController::class, 'show'])->name('categorias.show');
    Route::delete('/categorias/delete/{id}', [CategoriasController::class, 'delete'])->name('categorias.delete');

    Route::get('/getquestao/{id}', [QuestoesController::class, 'getQuestao'])->name('boQuestoes.getQuestao');
    Route::get('/questao/getTipos/{id}', [QuestoesController::class, 'getTipos'])->name('boQuestoes.getTipos');
    Route::post('/questao/order', [QuestoesController::class, 'order'])->name('questoes.order');
    Route::post('/questoes/save', [QuestoesController::class, 'save'])->name('questoes.save');
    Route::get('/questoes/show/{questao}', [QuestoesController::class, 'show'])->name('questoes.show');
    Route::delete('/questoes/delete/{id}', [QuestoesController::class, 'delete'])->name('questoes.delete');

    Route::post('/respostas/order', [RespostasController::class, 'order'])->name('respostas.order');
    Route::post('/respostas/save', [RespostasController::class, 'save'])->name('respostas.save');
    Route::delete('/respostas/delete/{id}', [RespostasController::class, 'delete'])->name('respostas.delete');
});

require __DIR__ . '/auth.php';

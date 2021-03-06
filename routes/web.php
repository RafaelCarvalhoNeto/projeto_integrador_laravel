<?php

use Facade\FlareClient\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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


Route::get('/institucional', function () {
    return view('institucional');
})->name('institucional');
Route::get('/404', function () {
    return view('404');
});

Route::get('/politicas', function () {
    return view('politicas');
})->name('politicas');

Route::get('/carrinho','CarrinhoController@index')->name('carrinho');

Route::get('/carrinho/adicionar', function(){
    return redirect()->route('index');
});
Route::post('/carrinho/adicionar', 'CarrinhoController@adicionar')->name('carrinho.adicionar');

Route::delete('/carrinho/remover','CarrinhoController@remover')->name('carrinho.remover');
Route::post('/carrinho/removerItemSession','CarrinhoController@removerItemSession')->name('carrinho.remover.ss');
Route::post('compraFinalizada', 'CarrinhoController@concluir')->name('pedido.concluido');
Route::get('finalizarCompra', 'CarrinhoController@compras')->name('pagina.finalizar');

Route::get('converterPedido', 'CarrinhoController@converterPedido')->name('converter.pedido');


Route::get('/usuarios/historicoPedidos', 'CarrinhoController@showHistorico')->name('show.historico');
Route::put('usuarios/editarFoto/{id}', 'UsersController@editFoto');

Route::get('/compraFinalizada', function () {
    return view('compraFinalizada');
});
// NAVEGAÇÃO SITE

Route::get('/', 'NavigateController@index')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/detalheProduto/{produto}', 'NavigateController@showDetails');

Route::get('/categoria/{categoria}', 'NavigateController@pagCategorias');

Route::get('/search', 'NavigateController@searchItems');

Route::get('/loginDirect', 'NavigateController@loginDirect')->name('login.direct');
Route::post('/login/do', 'NavigateController@login')->name('login.do');

Auth::routes();


// ACESSO ADMIN

Route::get('/admin', 'AuthController@dashboard')->name('admin');

Route::get('/admin/login', 'AuthController@showLoginForm')->name('admin.login');
Route::post('/admin/login/do', 'AuthController@login')->name('admin.login.do');

Route::post('/admin/logout','AuthController@logout')->name('admin.logout');

Route::put('/admin/toggleAdmin/{id}', 'AuthController@toggleAdmin');

// PRODUTOS
Route::get('/admin/admProdutos', 'ProdutosController@index')->name('admin.admProdutos');
Route::post('/admin/admProdutos/novo', 'ProdutosController@create');
Route::put('/admin/admProdutos/update/{id}', 'ProdutosController@update');
Route::put('/admin/admProdutos/promo/{id}', 'ProdutosController@promoUpdate');
Route::delete('/admin/admProdutos/{id}', 'ProdutosController@delete');
Route::get('/admin/admProdutos/search', 'ProdutosController@search');

Route::get('/admin/fatProdutos', 'ProdutosController@faturamento');

// USUARIOS
Route::get('/admin/admUsuarios', 'UsersController@listAllUsers')->name('users.listAll');

// EDITAR USUÁRIOS
Route::get('/usuarios/editUsuarios/{id}', 'UsersController@editUser');
Route::put('/usuarios/editUsuarios/{id}', 'UsersController@updateUser');

// CRIAR USUÁRIO
Route::get('/cadastro', 'UsersController@createPage')->name('cadastro.usuario');
Route::post('/cadastro', 'UsersController@createUser');

// DELETE USUÁRIO
Route::delete('/admin/remove/{id}', 'UsersController@deleteUser');

// SEARCH USUÁRIO
Route::get('/admin/admUsuarios/search', 'UsersController@searchUser');

// LISTAR CATEGORIAS
Route::get('/admin/admCategorias', 'CategoriasController@listAllCategorias')->name('categorias.listAll');

// ADICIONAR CATEGORIAS
Route::post('/admin/admCategorias', 'CategoriasController@createCategoria');

// SEARCH CATEGORIAS
Route::get('/admin/admCategorias/search', 'CategoriasController@searchCategoria');

// DELETE CATEGORIA
Route::delete('/admin/removeCategoria/{id}', 'CategoriasController@deleteCategoria');

Route::put('/admin/admCategorias/update/{id}', 'CategoriasController@update');

// LISTAR MENSAGENS
Route::get('/admin/admMensagens', 'MessageController@listMessage')->name('messages.listAll');

// ENVIAR DE MENSAGEM
Route::get('/contato', 'MessageController@pagContato')->name('contato');
Route::post('/contato', 'MessageController@sendMessage');

// DELETE MENSAGEM
Route::delete('/admin/removeMessage/{id}', 'MessageController@deleteMessage');

// SEARCH MENSAGENS
Route::get('admin/admMensagens/search', 'MessageController@searchMessage');

Route::put('/admin/toggleEmail/{id}', 'MessageController@toggleEmail');

// ENVIAR E-MAIL
Route::post('/sendemail/send', 'MessageController@send');


// ACESSO USUÁRIO

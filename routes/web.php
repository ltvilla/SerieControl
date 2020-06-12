<?php

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

use App\Mail\NovaSerie;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

Route::get('/series', 'SeriesController@index')
    ->name('listar_series')->middleware('autenticador');
Route::get('/series/criar', 'SeriesController@create')
    ->name('form_criar_serie')
    ->middleware('autenticador');
Route::post('/series/criar', 'SeriesController@store')
    ->middleware('autenticador');
Route::delete('/series/{id}', 'SeriesController@destroy')
    ->middleware('autenticador');
Route::post('/series/{id}/editaNome', 'SeriesController@editaNome')
    ->middleware('autenticador');

Route::get('/series/{serieId}/temporadas', 'TemporadasController@index')->middleware('autenticador');

Route::get('/temporadas/{temporada}/episodios', 'EpisodiosController@index')->middleware('autenticador');

Route::post('/temporadas/{temporada}/episodios/assistir', 'EpisodiosController@assistir')
    ->middleware('autenticador');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/entrar', 'EntrarController@index');
Route::post('/entrar', 'EntrarController@entrar');
Route::get('/registrar', 'RegistroController@create');
Route::post('/registrar', 'RegistroController@store');

Route::get('/sair', function () {
    \Illuminate\Support\Facades\Auth::logout();
    return redirect('/entrar');
});


Route::get('/visualizando-email', function() {
    return new NovaSerie(
        'Arrow',
        5,
        4
    );
});

Route::get('/enviando-email', function() {
    $email = new NovaSerie(
        'Arrow',
        5,
        4
    );

    $email->subject = 'Nova Série Adicionada';

    $user = (object)[
        'email' => 'tiago@teste.com',
        'name' => 'Tiago'
    ];

    Mail::to($user)->send($email);

    return 'Email enviado!';
});

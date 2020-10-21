<?php

use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\AdminCheck;
use \App\Jobs\QueueSendEmailJob;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('queueSendEmail',function (){
    QueueSendEmailJob::dispatch()
        ->delay(now()->addSecond(15));
    return 'Email send properly';
});

//Route::get('/home', 'HomeController@index')->name('home');
Route::get('/testpage', 'TestController@index')->name('home');

Route::get('send-mail','MailSend@mailsend');

Route::prefix('app')->middleware([AdminCheck::class])->group(function(){
    Route::post('/create_tag', 'AdminController@addTag');
    Route::get('/get_tag', 'AdminController@getTag');
    Route::post('/edit_tag', 'AdminController@editTag');
    Route::post('/delete_tag', 'AdminController@deleteTag');
//category
    Route::post('/create_category', 'AdminController@addCategory');
    Route::post('/upload', 'AdminController@upload');
    Route::post('/delete_image', 'AdminController@deleteimage');
    Route::get('/get_category', 'AdminController@getCategory');
    Route::post('/delete_category', 'AdminController@deleteCategory');
//admin
    Route::post('/create_user', 'AdminController@createUser');
    Route::get('/get_users', 'AdminController@getUsers');
    Route::post('/edit_user', 'AdminController@editUser');
    Route::post('/admin_login', 'AdminController@adminLogin');

    //role managment
    Route::post('/create_role', 'AdminController@createRole');
    Route::get('/get_roles', 'AdminController@getRoles');
    Route::get('/get_resources', 'AdminController@getResources');
    Route::post('/assign_roles', 'AdminController@assignRole');

    //IT related services
    Route::get('/ldcservices', 'LDCServiceController@index');
    Route::post('/ldcservices', 'LDCServiceController@store');
    Route::post('/edit_service', 'LDCServiceController@update');

});

//login check
Route::get('/', 'AdminController@index');
Route::get('/logout', 'AdminController@logout');
Route::any('{slug}', 'AdminController@index');
//Route::any('{slug}', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

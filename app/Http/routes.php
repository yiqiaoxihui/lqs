<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');
// 密码重置链接请求路由...
Route::get('password/email', 'Auth\PasswordController@getEmail');
Route::post('password/email', 'Auth\PasswordController@postEmail');
// 密码重置路由...
Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
Route::post('password/reset', 'Auth\PasswordController@postReset');

Route::get('/', 'YkController@home');

Route::group(['middleware' => 'auth'], function() {
    Route::get('home', 'YkController@index');//
    Route::get('yktrend', 'YkController@index');//
    Route::get('ykNumber', 'YkController@ykNumber');//
    Route::get('ykType', 'YkController@ykType');//
    Route::post('yearOfyktype', 'YkController@yearOfyktype');//
    Route::get('ykSource', 'YkController@ykSource');//
    Route::post('yearOfyksource', 'YkController@yearOfyksource');//
    //
    Route::get('pepCompare','ImagesController@pepCompare');//
    Route::post('yearOfYkCompare','ImagesController@yearOfYkCompare');
    Route::get('incomeCompare','ImagesController@incomeCompare');//
    Route::post('yearOfIncomeCompare','ImagesController@yearOfIncomeCompare');//
    //
    Route::get('incomeSource','FilesController@incomeSource');
    Route::post('yearOfIncomeSource','FilesController@yearOfIncomeSource');
    Route::get('incomeSum','FilesController@incomeSum');
    Route::get('incomeAccumulate','FilesController@incomeAccumulate');
    //
    Route::get('spotsYk','UsersController@spotsYk');    
});
// Route::get('home', function () {

//     return view('home/yktrend');
// });



Route::group(['middleware' => 'auth','namespace' => 'Admin', 'prefix' => 'admin'], function() {  
    Route::get('/', 'HomeController@index');
    Route::post('addServer', 'HomeController@addServer');
    Route::get('serverEdit/{id}', 'HomeController@serverEdit');
    Route::post('serverEditOk', 'HomeController@serverEditOk');
    Route::post('serverDelete', 'HomeController@serverDelete');
    Route::post('serverStop', 'HomeController@serverStop');
    Route::post('serverStart', 'HomeController@serverStart');
  
    // Route::get('ykNumber', 'HomeController@ykNumber');
    // Route::post('ykNumberAdd', 'HomeController@ykNumberAdd');
    // Route::get('ykNumberEdit/{id}', 'HomeController@ykNumberEdit');
    // Route::post('ykNumberEditOk', 'HomeController@ykNumberEditOk');
    //
    // Route::get('ykType', 'HomeController@ykType');
    // Route::post('yktypeAdd', 'HomeController@yktypeAdd');
    // Route::get('ykTypeEdit/{id}', 'HomeController@ykTypeEdit');
    // Route::post('ykTypeEditOk', 'HomeController@ykTypeEditOk'); 
    // 
    // Route::get('ykSource', 'HomeController@ykSource');
    // Route::post('ykSourceAdd', 'HomeController@ykSourceAdd');
    // Route::get('ykSourceEdit/{id}', 'HomeController@ykSourceEdit');
    // Route::post('ykSourceEditOk', 'HomeController@ykSourceEditOk');     

});
//同期比
Route::group(['middleware' => 'auth','namespace' => 'Admin', 'prefix' => 'image'], function() {  
    
    Route::get('base', 'ImagesController@base');
    Route::post('baseAdd', 'ImagesController@baseAdd');
    Route::get('baseEdit/{id}', 'ImagesController@baseEdit');
    Route::post('baseEditOk', 'ImagesController@baseEditOk'); 
    Route::post('baseStart', 'ImagesController@baseStart');
    Route::post('baseStop', 'ImagesController@baseStop'); 
    Route::post('baseDelete', 'ImagesController@baseDelete'); 
   
    Route::get('overlay', 'ImagesController@overlay');
    Route::post('overlayAdd', 'ImagesController@overlayAdd');
    Route::get('overlayEdit/{id}', 'ImagesController@overlayEdit');
    Route::post('overlayEditOk', 'ImagesController@overlayEditOk');   
    Route::post('getBaseimageByServer', 'ImagesController@getBaseimageByServer');   
    Route::post('overlayStart', 'ImagesController@overlayStart');
    Route::post('overlayStop', 'ImagesController@overlayStop'); 
    Route::post('overlayDelete', 'ImagesController@overlayDelete'); 

});
//
Route::group(['middleware' => 'auth','namespace' => 'Admin', 'prefix' => 'file'], function() {  
    //
    Route::get('fileInfo', 'FilesController@fileInfo');
    Route::post('fileAdd', 'FilesController@fileAdd');
    //detect
    
    Route::post('fileRestore', 'FilesController@fileRestore');
    Route::post('fileRestoreCancel', 'FilesController@fileRestoreCancel');
    Route::post('fileStart', 'FilesController@fileStart');
    Route::post('fileStop', 'FilesController@fileStop');
    Route::get('fileEdit/{id}', 'FilesController@fileEdit');
    Route::post('fileEditOk', 'FilesController@fileEditOk'); 
    Route::post('fileDelete', 'FilesController@fileDelete');
    Route::post('getBaseimageByServer', 'FilesController@getBaseimageByServer');
    Route::post('getOverlayByBase', 'FilesController@getOverlayByBase');
    //
    Route::get('fileRestoreInfo', 'FilesController@fileRestoreInfo');
    // Route::post('incomeSumAdd', 'FilesController@incomeSumAdd');
    // Route::get('incomeSumEdit/{id}', 'FilesController@incomeSumEdit');
    // Route::post('incomeSumEditOk', 'FilesController@incomeSumEditOk');     
    // //
    // Route::get('fileRestoreRecord', 'FilesController@fileRestoreRecord');
    // Route::post('incomeAccumulateUpdate', 'FilesController@incomeAccumulateUpdate');


});
//
Route::group(['middleware' => 'auth','namespace' => 'Admin','prefix' => 'user'], function() {  
    //
    Route::get('userInfo', 'UsersController@userInfo');
    Route::post('spotsYkAdd', 'UsersController@spotsYkAdd');
    Route::get('spotsYkEdit/{id}', 'UsersController@spotsYkEdit');
    Route::post('spotsYkEditOk', 'UsersController@spotsYkEditOk'); 


});
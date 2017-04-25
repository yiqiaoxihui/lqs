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
    Route::get('home', 'YkController@index');//近7日游客走势
    Route::get('yktrend', 'YkController@index');//近7日游客走势
    Route::get('ykNumber', 'YkController@ykNumber');//游客数量走势12月
    Route::get('ykType', 'YkController@ykType');//游客类型分析
    Route::post('yearOfyktype', 'YkController@yearOfyktype');//游客类型分析
    Route::get('ykSource', 'YkController@ykSource');//游客客源地分析
    Route::post('yearOfyksource', 'YkController@yearOfyksource');//游客客源地分析
    //同期比
    Route::get('pepCompare','ImagesController@pepCompare');//游客同期比
    Route::post('yearOfYkCompare','ImagesController@yearOfYkCompare');
    Route::get('incomeCompare','ImagesController@incomeCompare');//收入同期比
    Route::post('yearOfIncomeCompare','ImagesController@yearOfIncomeCompare');//收入同期比
    //收入分析
    Route::get('incomeSource','FilesController@incomeSource');
    Route::post('yearOfIncomeSource','FilesController@yearOfIncomeSource');
    Route::get('incomeSum','FilesController@incomeSum');
    Route::get('incomeAccumulate','FilesController@incomeAccumulate');
    //景点客流
    Route::get('spotsYk','UsersController@spotsYk');    
});
// Route::get('home', function () {

//     return view('home/yktrend');
// });


//游客分析
Route::group(['middleware' => 'auth','namespace' => 'Admin', 'prefix' => 'admin'], function() {  
    Route::get('/', 'HomeController@index');
    Route::post('addServer', 'HomeController@addServer');
    Route::get('serverEdit/{id}', 'HomeController@serverEdit');
    Route::post('serverEditOk', 'HomeController@serverEditOk');
    Route::post('serverDelete', 'HomeController@serverDelete');
    Route::post('serverStop', 'HomeController@serverStop');
    Route::post('serverStart', 'HomeController@serverStart');
    // //游客数量走势图
    // Route::get('ykNumber', 'HomeController@ykNumber');
    // Route::post('ykNumberAdd', 'HomeController@ykNumberAdd');
    // Route::get('ykNumberEdit/{id}', 'HomeController@ykNumberEdit');
    // Route::post('ykNumberEditOk', 'HomeController@ykNumberEditOk');
    // //游客类型分析
    // Route::get('ykType', 'HomeController@ykType');
    // Route::post('yktypeAdd', 'HomeController@yktypeAdd');
    // Route::get('ykTypeEdit/{id}', 'HomeController@ykTypeEdit');
    // Route::post('ykTypeEditOk', 'HomeController@ykTypeEditOk'); 
    // //游客客源地分析
    // Route::get('ykSource', 'HomeController@ykSource');
    // Route::post('ykSourceAdd', 'HomeController@ykSourceAdd');
    // Route::get('ykSourceEdit/{id}', 'HomeController@ykSourceEdit');
    // Route::post('ykSourceEditOk', 'HomeController@ykSourceEditOk');     

});
//同期比
Route::group(['middleware' => 'auth','namespace' => 'Admin', 'prefix' => 'image'], function() {  
    //游客人数同期比
    Route::get('base', 'ImagesController@base');
    Route::post('baseAdd', 'ImagesController@baseAdd');
    Route::get('baseEdit/{id}', 'ImagesController@baseEdit');
    Route::post('baseEditOk', 'ImagesController@baseEditOk'); 
    Route::post('baseStart', 'ImagesController@baseStart');
    Route::post('baseStop', 'ImagesController@baseStop'); 
    Route::post('baseDelete', 'ImagesController@baseDelete'); 
    //收入同期比
    Route::get('overlay', 'ImagesController@overlay');
    Route::post('overlayAdd', 'ImagesController@overlayAdd');
    Route::get('overlayEdit/{id}', 'ImagesController@overlayEdit');
    Route::post('overlayEditOk', 'ImagesController@overlayEditOk');   
    Route::post('getBaseimageByServer', 'ImagesController@getBaseimageByServer');   
    Route::post('overlayStart', 'ImagesController@overlayStart');
    Route::post('overlayStop', 'ImagesController@overlayStop'); 
    Route::post('overlayDelete', 'ImagesController@overlayDelete'); 

});
//收入分析
Route::group(['middleware' => 'auth','namespace' => 'Admin', 'prefix' => 'file'], function() {  
    //收入来源
    Route::get('fileInfo', 'FilesController@fileInfo');
    Route::post('fileAdd', 'FilesController@fileAdd');
    //detect
    Route::post('fileStart', 'FilesController@fileStart');
    Route::post('fileStop', 'FilesController@fileStop');
    Route::get('fileEdit/{id}', 'FilesController@fileEdit');
    Route::post('fileEditOk', 'FilesController@fileEditOk'); 
    Route::post('fileDelete', 'FilesController@fileDelete');
    Route::post('getBaseimageByServer', 'FilesController@getBaseimageByServer');
    Route::post('getOverlayByBase', 'FilesController@getOverlayByBase');
    //收入总计
    // Route::get('incomeSum', 'FilesController@incomeSum');
    // Route::post('incomeSumAdd', 'FilesController@incomeSumAdd');
    // Route::get('incomeSumEdit/{id}', 'FilesController@incomeSumEdit');
    // Route::post('incomeSumEditOk', 'FilesController@incomeSumEditOk');     
    // //收入累计
    // Route::get('incomeAccumulate', 'FilesController@incomeAccumulate');
    // Route::post('incomeAccumulateUpdate', 'FilesController@incomeAccumulateUpdate');


});
//景点客流
Route::group(['middleware' => 'auth','namespace' => 'Admin','prefix' => 'user'], function() {  
    //景点客流 统计
    Route::get('userInfo', 'UsersController@userInfo');
    Route::post('spotsYkAdd', 'UsersController@spotsYkAdd');
    Route::get('spotsYkEdit/{id}', 'UsersController@spotsYkEdit');
    Route::post('spotsYkEditOk', 'UsersController@spotsYkEditOk'); 


});
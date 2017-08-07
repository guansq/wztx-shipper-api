<?php

use think\Route;
Route::any('apiCode','Index/apiCode');
Route::any('appConfig','Index/appConfig');
Route::any('lastApk','Index/lastApk');

Route::get('index/home','Index/home');
Route::post('index/sendCaptcha','Index/sendCaptcha');
Route::get('index/getArticle','Index/getArticle');

Route::get('user/info','User/info');
Route::get('user/computeQlfScore','User/computeQlfScore');
Route::post('user/login','User/login');
Route::post('user/uploadAvatar','User/uploadAvatar');
Route::put('user/updateInfo','User/updateInfo');
Route::get('user/qualification','User/qualification');
Route::post('user/qualification','User/saveQualification');
Route::post('user/uploadQfctImg','User/uploadQfctImg');

Route::post('ask/reply','Ask/reply');

Route::post('inquiry/quote','inquiry/quote');

Route::put('po/agree','PO/agree');
Route::put('po/refuse','PO/refuse');


return [
    //-------------------
    //  __domain__  域名部署
    //-------------------
    '__domain__'=>[
        'wztx.shp.api' => 'api',
    ],
    '__rest__' => [
        'index' => 'Index',             // 路径 =》 控制器
        'supporter' => 'Supporter',
        'inquiry' => 'Inquiry',
        'po' => 'PO',
      //  'message' => 'Message',
        'ask' => 'Ask',
    ],
];

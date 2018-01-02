<?php 
Route::get('/test','Test\TestController@test');
Route::get('/fix/ip','Test\TestController@fixIp');
Route::get('/yibu','Test\TestController@yibu');
Route::any('/yibutest','Test\TestController@yibutest');
 ?>
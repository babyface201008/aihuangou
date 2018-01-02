<?php 
Route::group(['middlerware'=>'WelkinApi','prefix'=>'/api'],function(){
    Route::get('/',function(){ echo "mcy api List";});
    Route::get('/get/news','Api\ApiController@apiGetNews');
    Route::get('/get/new/{new_id}','Api\ApiController@apiGetNewDetail');

    Route::get('/getRiChangNav','Api\ApiMcyController@apiGetRiChangNav');

    Route::post('/mcyLogin','Api\ApiMcyController@apiCheckLogin');

});

 ?>

<?php

/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api/v1', 'before' => ''], function ()
{
    Route::post('memo', ['as' => 'api.post.memo', 'uses' => 'Api\ApiAdminMemoController@store']);
    Route::put('memo', ['as' => 'api.put.memo', 'uses' => 'Api\ApiAdminMemoController@update']);
    Route::get('memo', ['as' => 'api.show.memo', 'uses' => 'Api\ApiAdminMemoController@show']);
    Route::get('memo', ['as' => 'api.edit.memo', 'uses' => 'Api\ApiAdminMemoController@edit']);
    Route::delete('memo', ['as' => 'api.delete.memo', 'uses' => 'Api\ApiAdminMemoController@destroy']);
});
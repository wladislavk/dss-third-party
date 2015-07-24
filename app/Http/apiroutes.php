<?php

/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api/v1', 'before' => ''], function ()
{
    Route::resource('memo','Api\ApiAdminMemoController');
});
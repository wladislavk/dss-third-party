<?php

/*
|--------------------------------------------------------------------------
| API routes
|--------------------------------------------------------------------------
*/

Route::group(['prefix' => 'api/v1', 'before' => '', 'after' => 'allowOrigin'], function ()
{
    Route::resource('memo','Api\ApiAdminMemoController');
});
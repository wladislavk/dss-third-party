<?php

// API Routes - this will be protected by JWT
include('apiroutes.php');


/*
|--------------------------------------------------------------------------
| All protected routes will go here...
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => 'jwt.auth'], function () {

    // eg.:
    Route::get('auth-only', function () {
        // Get user data by provided token
        return JWTAuth::parseToken()->toUser();
    });
});

/*
|--------------------------------------------------------------------------
| Authenticate user and get a token for subsequent requests
|--------------------------------------------------------------------------
*/
Route::post('auth', function () {
    if (!$token = JWTAuth::attempt(Request::all())) {
        return new Illuminate\Http\JsonResponse(['status' => 'Invalid credentials'], 422);
    }

    return ['status' => 'Authenticated', 'token' => $token];
});



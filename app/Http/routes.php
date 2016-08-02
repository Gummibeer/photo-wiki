<?php

Route::get('/', function () {
    return redirect()->route('app.get.dashboard.show');
});
Route::get('/app', function () {
    return redirect()->route('app.get.dashboard.show');
});
Route::get('/auth', function () {
    return redirect()->route('auth.get.login');
});

/* AUTH */
Route::group([
    'prefix' => 'auth',
    'namespace' => 'Auth',
], function () {
    Route::get('login', 'AuthController@showLoginForm')
        ->name('auth.get.login');
    Route::post('login', 'AuthController@login')
        ->name('auth.post.login');
    Route::get('register', 'AuthController@showRegistrationForm')
        ->name('auth.get.register');
    Route::post('register', 'AuthController@register')
        ->name('auth.post.register');
    Route::get('logout', 'AuthController@logout')
        ->name('auth.get.logout');

    Route::get('verification/{token}', 'AuthController@getVerification')
        ->name('auth.get.verification');
    Route::get('verification/error', 'AuthController@getVerificationError')
        ->name('auth.get.verification.error');
});

/* APP */
Route::group([
    'prefix' => 'app',
    'namespace' => 'App',
], function () {
    Route::get('/dashboard', 'DashboardController@getShow')
        ->name('app.get.dashboard.show');

    Route::group(['prefix' => 'user'], function () {
        Route::get('/read-notifications/{id?}', 'UserController@getReadNotifications')
            ->name('app.get.user.read-notification');
    });

    Route::group([
        'prefix' => 'management',
        'namespace' => 'Management',
    ], function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'UserController@getIndex')
                ->name('app.management.get.user.index');
            Route::get('/{user}', 'UserController@getEdit')
                ->name('app.management.get.user.edit');
            Route::put('/{user}', 'UserController@putEdit')
                ->name('app.management.put.user.edit');
        });
    });
});
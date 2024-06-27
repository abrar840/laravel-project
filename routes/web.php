<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth;
use App\Http\Controllers\userController;

use App\Http\Controllers\resetController;

use App\Http\Middleware\checkrole;

use App\Http\Middleware\EnsureUserHasRole;

Route::get('/', function () {
    return view('welcome');
});

 
 



 



    Route::post('/logout', [userController::class, 'logout'])->name('log.out');





Route::middleware([EnsureUserHasRole::class . ':user,admin'])->group(function () {
    // Define routes that require the 'editor' role here
    Route::get('/home', function () {
        return view('home');
    })->name('home');
    // Other routes requiring 'editor' role
});

 



Route::middleware(['guest'])->group(function () {  });

Route::get('/signup', function () {
    return view('signup');
});


Route::get('/login', function () {
    return view('login');
})->name('login');








Route::middleware([EnsureUserHasRole::class . ':admin'])->group(function () {



//Route::get('/admin', [userController::class, 'admin'])->name('admin.panel');

Route::get('/admin', function () {
    return view('adminpanel');
})->name('admin');

});












Route::post('/signup', [userController::class, 'signup'])->name('sign.up');


Route::post('/in', [userController::class, 'login'])->name('log.in');


Route::post('/reset', [resetController::class, 'updatepassword']);

Route::get('/password_reset', function () {
    return view('reset');
});



Route::get('/password/reset/{token}', [resetController::class, 'showResetForm'])->name('password.reset');



// Route to handle the reset password form submission
Route::post('/password/reset', [resetController::class, 'reset'])->name('password.update');
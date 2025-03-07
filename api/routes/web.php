<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    return redirect(route("facebook.redirect"));
});


Route::get("/facebook/auth/redirect", function () {
    return Socialite::driver("facebook")->redirect();
})->name("facebook.redirect");

Route::get("/facebook/auth/callback", function() {
    $user = Socialite::driver("facebook")->user();

    return $user;
})->name("facebook.callback");
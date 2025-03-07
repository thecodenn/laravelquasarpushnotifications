<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/', function () {
    print "<p><a href='".route("facebook.redirect")."'>Facebook login (oauth!)</a></p>";
    print "<p><a href='".route("saml.redirect")."'>SAML login</a></p>";
});


Route::get("/facebook/auth/redirect", function () {
    return Socialite::driver("facebook")
            ->redirect();
})->name("facebook.redirect");

Route::get("/facebook/auth/callback", function() {
$user = Socialite::driver("facebook")->user();
       print "<p>name: ". $user->name."</p>";
       print "<p>id: ".substr($user->id, 3)."************</p>";
       print "<p>email: we have hit</p>";
       print "<img src='".$user->avatar."'>";
})->name("facebook.callback");



Route::get("/saml/auth/redirect", function () {
    return Socialite::driver("saml2")
            ->redirect();
})->name("saml.redirect");

Route::post("/saml/auth/callback", function() {
$user = Socialite::driver("saml2")->user();
       print "<p>name: ". $user->name."</p>";
       print "<p>id: ".substr($user->id, 3)."************</p>";
       print "<p>email: we have hit</p>";
       print "<img src='".$user->avatar."'>";
})->name("saml.callback")->withoutMiddleware([VerifyCsrfToken::class]); // Disables CSRF for this route

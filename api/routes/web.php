<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Log;
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

    Log::debug("in saml/auth/redirect");
    return Socialite::driver("saml2")
            ->redirect();
    Log::debug("returned");
})->name("saml.redirect");



Route::post("/saml/auth/callback", function() {
    // https://dummyidp.com/apps/app_01jp1y7dh58bypgn5zw9rxyq90
    Log::debug("in callback!");

    // Get the encoded SAML response from the request
    $samlResponse = request()->input('SAMLResponse');

    if ($samlResponse) {
        // Decode the base64 URL-encoded response
        $decodedSamlResponse = base64_decode(urldecode($samlResponse));
        

        Log::debug('Decoded SAML Response: ', ['urldecode' => urldecode($samlResponse)]);

        // Log the decoded SAML response for debugging
        Log::debug('Decoded SAML Response: ', ['response' => $decodedSamlResponse]);

        try {
            // // Now pass the decoded response to the Socialite driver
            // $user = Socialite::driver("saml2")->userFromSamlResponse($decodedSamlResponse);
            $user = Socialite::driver('saml2')->stateless()->user();

            Log::debug('User: ', (array)$user);
        } catch (\Exception $e) {
            Log::error('Error during SAML authentication: ' . $e->getMessage());
        }
    } else {
        Log::error('No SAMLResponse found in the request');
    }

    // $user = Socialite::driver("saml2")->user();
    //        print "<p>name: ". $user->name."</p>";
    //        print "<p>id: ".substr($user->id, 3)."************</p>";
    //        print "<p>email: we have hit</p>";
    //        print "<img src='".$user->avatar."'>";
})->name("saml.callback")->withoutMiddleware([VerifyCsrfToken::class]); // Disables CSRF for this route

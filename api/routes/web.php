<?php

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

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
       print "<p>id: ".substr($user->id,0, 3)."************</p>";
       print "<p>email: we have hit</p>";
       print "<img src='".$user->avatar."'>";
})->name("facebook.callback");
    
    

Route::get('/saml/auth/metadata', function () {
    return Socialite::driver('saml2')->getServiceProviderMetadata();
});

Route::get("/saml/auth/redirect", function () {

    Log::debug("in saml/auth/redirect");
    return Socialite::driver("saml2")
            ->redirect();
    Log::debug("returned");
})->name("saml.redirect");


Route::post("/saml/auth/callback", function() {
    // https://dummyidp.com/apps/app_01jp1y7dh58bypgn5zw9rxyq90
    Log::debug("in callback!");

    // Optionally log the raw SAMLResponse without decoding
    // $rawSamlResponse = request()->input('SAMLResponse');
    // Log::debug('Raw SAML Response: ', ['response' => $rawSamlResponse]);

    // $decodedSamlResponse = base64_decode($rawSamlResponse);
    // Log::debug('Decoded SAML Response: ', ['response' => $decodedSamlResponse]);


        $user = Socialite::driver('saml2')->stateless()->user();
        Log::debug("user: ".print_r($user, true));
        Log::debug("user email: ".$user->getEmail());
        Log::debug("user id: ".$user->getId());
        Log::debug('User attributes: ', $user->attributes);

        $email = $user->getId();

        $user = User::where('email', $email)->first();


        Auth::login($user);

        if (Auth::check()) {
        print "<p>name: ". $user->name."</p>";
       print "<p>id: ".substr($user->id, 0, 3)."************</p>";
       print "<p>email: we have hit</p>";
        } else {
                print "user not logged in...";
        }

})->name("saml.callback")->withoutMiddleware([VerifyCsrfToken::class]); // Disables CSRF for this route

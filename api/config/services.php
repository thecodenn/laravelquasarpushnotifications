<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT'),
    ],

    'saml2' => [
        'metadata' => 'https://dummyidp.com/apps/app_01jnr1jcz32x4ryrxx2k2s3w4q/metadata',
        'certificate' => file_get_contents('/home/john/Projects/quasar/saml.crt'),
      ],

      'saml2' => [
        'metadata' => env('SAML2_METADATA_URL'), // Metadata URL of the IdP
        'entityid' => env('SAML2_ENTITY_ID'), // Your Service Provider Entity ID
        'relay_state' => env('SAML2_RELAY_STATE'), // Optional Relay State
        'cert' => env('SAML2_CERT_PATH'), // Path to your certificate file
        'key' => env('SAML2_KEY_PATH'), // Path to your private key file
        'sp_entityid' => env('SAML2_SP_ENTITY_ID'), // Your SP Entity ID
        'idp_entityid' => env('SAML2_IDP_ENTITY_ID'), // Your IdP Entity ID
        'idp_sso_url' => env('SAML2_IDP_SSO_URL'), // Your IdP Login URL
        'idp_slo_url' => env('SAML2_IDP_SLO_URL'), // Your IdP Logout URL
        'idp_x509cert' => env('SAML2_IDP_X509CERT'), // Your IdP X509 Certificate
    ],
    

];

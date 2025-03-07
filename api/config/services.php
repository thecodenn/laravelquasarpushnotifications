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



    //   'saml2' => [
    //     'metadata' => env('SAML2_METADATA_URL'), // Metadata URL of the IdP
    //     'entityid' => env('SAML2_ENTITY_ID'), // Your Service Provider Entity ID
    //     'relay_state' => env('SAML2_RELAY_STATE'), // Optional Relay State
    //     'cert' => env('SAML2_CERT_PATH'), // Path to your certificate file
    //     'key' => env('SAML2_KEY_PATH'), // Path to your private key file
    //     'sp_entityid' => env('SAML2_SP_ENTITY_ID'), // Your SP Entity ID
    //     'idp_entityid' => env('SAML2_IDP_ENTITY_ID'), // Your IdP Entity ID
    //     'idp_sso_url' => env('SAML2_IDP_SSO_URL'), // Your IdP Login URL
    //     'idp_slo_url' => env('SAML2_IDP_SLO_URL'), // Your IdP Logout URL
    //     'idp_x509cert' => env('SAML2_IDP_X509CERT'), // Your IdP X509 Certificate
    // ],

    'saml2' => [
        'metadata' => 'https://dummyidp.com/apps/app_01jnr1jcz32x4ryrxx2k2s3w4q/metadata',
        // 'entityid' => 'https://saml.demoserver.co.za/saml',
        // 'acs' => 'https://saml.demoserver.co.za/saml/auth/callback',
        // 'relay_state' => '',
        // 'certificate' => "-----BEGIN CERTIFICATE-----
        // MIIDBzCCAe+gAwIBAgIUCLBK4f75EXEe4gyroYnVaqLoSp4wDQYJKoZIhvcNAQEL
        // BQAwEzERMA8GA1UEAwwIZHVtbXlpZHAwHhcNMjQwNTEzMjE1NDE2WhcNMzQwNTEx
        // MjE1NDE2WjATMREwDwYDVQQDDAhkdW1teWlkcDCCASIwDQYJKoZIhvcNAQEBBQAD
        // ggEPADCCAQoCggEBAKhmgQmWb8NvGhz952XY4SlJlpWIK72RilhOZS9frDYhqWVJ
        // HsGH9Z7sSzrM/0+YvCyEWuZV9gpMeIaHZxEPDqW3RJ7KG51fn/s/qFvwctf+CZDj
        // yfGDzYs+XIgf7p56U48EmYeWpB/aUW64gSbnPqrtWmVFBisOfIx5aY3NubtTsn+g
        // 0XbdX0L57+NgSvPQHXh/GPXA7xCIWm54G5kqjozxbKEFA0DS3yb6oHRQWHqIAM/7
        // mJMdUVZNIV1q7c2JIgAl23uDWq+2KTE2R5liP/KjvjwKonVKtTqGqX6ei25rsTHO
        // aDpBH/LdQK2txgsm7R7+IThWNvUI0TttrmwBqyMCAwEAAaNTMFEwHQYDVR0OBBYE
        // FD142gxIAJMhpgMkgpzmRNoW9XbEMB8GA1UdIwQYMBaAFD142gxIAJMhpgMkgpzm
        // RNoW9XbEMA8GA1UdEwEB/wQFMAMBAf8wDQYJKoZIhvcNAQELBQADggEBADQd6k6z
        // FIc20GfGHY5C2MFwyGOmP5/UG/JiTq7Zky28G6D0NA0je+GztzXx7VYDfCfHxLcm
        // 2k5t9nYhb9kVawiLUUDVF6s+yZUXA4gUA3KoTWh1/oRxR3ggW7dKYm9fsNOdQAbx
        // UUkzp7HLZ45ZlpKUS0hO7es+fPyF5KVw0g0SrtQWwWucnQMAQE9m+B0aOf+92y7J
        // QkdgdR8Gd/XZ4NZfoOnKV7A1utT4rWxYCgICeRTHx9tly5OhPW4hQr5qOpngcsJ9
        // vhr86IjznQXhfj3hql5lA3VbHW04ro37ROIkh2bShDq5dwJJHpYCGrF3MQv8S3m+
        // jzGhYL6m9gFTm/8=
        // -----END CERTIFICATE-----"
    ],


];

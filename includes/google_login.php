<?php

require_once __DIR__.'/config.php';

// URL endpoint Google OAuth 2.0
$google_oauth_url = 'https://accounts.google.com/o/oauth2/v2/auth?'.http_build_query([
    'client_id' => GOOGLE_CLIENT_ID,
    'redirect_uri' => GOOGLE_REDIRECT_URI,
    'response_type' => 'code',
    'scope' => 'openid email profile',
    'access_type' => 'offline',
    'prompt' => 'consent',
]);

header('Location: '.$google_oauth_url);
exit;

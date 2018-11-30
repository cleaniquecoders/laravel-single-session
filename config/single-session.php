<?php

return [
    'enabled'  => env('SINGLE_SESSION_ENABLED', false),
    'prefix'   => 'auth-single-session-',
    'duration' => config('session.lifetime'),
];

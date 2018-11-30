<?php

if (! function_exists('singleSession')) {
    function singleSession(string $identifier)
    {
        return \CleaniqueCoders\LaravelSingleSession\Services\SingleSession::make($identifier);
    }
}

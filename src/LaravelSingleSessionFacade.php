<?php

namespace CleaniqueCoders\LaravelSingleSession;

/*
 * This file is part of laravel-single-session
 *
 * @license MIT
 * @package laravel-single-session
 */

use Illuminate\Support\Facades\Facade;

class LaravelSingleSessionFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'LaravelSingleSession';
    }
}

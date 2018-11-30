<?php

namespace CleaniqueCoders\LaravelSingleSession\Services;

use CleaniqueCoders\LaravelSingleSession\Exceptions\SingleSessionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class SingleSession
{
    /**
     * Single Session Identifier.
     *
     * @var string
     */
    private $identifier;

    /**
     * Construct Single Session Object.
     *
     * @param string $identifier
     */
    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Make statically Single Session Service.
     *
     * @param string $identifier
     *
     * @return self
     */
    public static function make(string $identifier)
    {
        return new self($identifier);
    }

    /**
     * Is single session is enabled.
     *
     * @return bool
     */
    public function enabled(): bool
    {
        return config('single-session.enabled');
    }

    /**
     * Get Single Session Idenfier Key.
     *
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Get error message for single session.
     *
     * @return string
     */
    public function getErrorMessage(): string
    {
        return __('You already logged in on other device.');
    }

    /**
     * Get Cache Key Use for single session.
     *
     * @return string
     */
    public function getCacheKey(): string
    {
        return config('single-session.prefix') . Str::snake($this->getIdentifier());
    }

    /**
     * Check if has single session cache.
     *
     * @return bool
     */
    public function hasSingleSession(): bool
    {
        return Cache::has($this->getCacheKey());
    }

    /**
     * Validate single session exist.
     */
    public function validate()
    {
        if (! $this->enabled()) {
            return;
        }

        if ($this->hasSingleSession()) {
            throw new SingleSessionException($this->getErrorMessage(), 401);
        }

        return $this;
    }

    public function get()
    {
        if (! $this->enabled()) {
            return;
        }

        if (! $this->hasSingleSession()) {
            return;
        }

        return Cache::get($this->getCacheKey());
    }

    /**
     * Set Current User in Single Session.
     */
    public function set()
    {
        if (! $this->enabled()) {
            return;
        }

        Cache::remember($this->getCacheKey(), config('single-session.duration'), function () {
            return auth()->user();
        });

        return $this;
    }

    /**
     * Destroy Current User in Single Session.
     */
    public function destroy()
    {
        if (! $this->enabled()) {
            return;
        }

        Cache::forget($this->getCacheKey());
    }
}

<?php

namespace CleaniqueCoders\LaravelSingleSession\Tests;

use Closure;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

class SingleSessionTest extends TestCase
{
    use Traits\UserTrait, RefreshDatabase;

    /**
     * Setup the test environment.
     */
    public function setUp()
    {
        parent::setUp();

        $this->artisan('vendor:publish', [
            '--provider' => \CleaniqueCoders\LaravelSingleSession\LaravelSingleSessionServiceProvider::class,
        ]);

        $this->loadLaravelMigrations(['--database' => 'testbench']);

        $this->seedUsers();
    }

    /** @test */
    public function it_has_single_session_service()
    {
        $this->assertTrue(class_exists(\CleaniqueCoders\LaravelSingleSession\Services\SingleSession::class));
    }

    /** @test */
    public function it_has_single_session_helper()
    {
        $this->assertTrue(function_exists('singleSession'));
    }

    /** @test */
    public function it_has_single_session_config()
    {
        $this->assertFileExists(config_path('single-session.php'));
    }

    /** @test */
    public function it_has_single_session_config_not_null()
    {
        $this->assertNotNull(config('single-session'));
    }

    /** @test */
    public function it_can_create_single_session()
    {
        $user          = $this->getAUser();
        $singleSession = singleSession($user->email);

        $this->mockRememberCache($singleSession->getCacheKey(), config('single-session.duration'), $user);
        $this->mockHasCache($singleSession->getCacheKey());

        singleSession($user->email)->set();
        singleSession($user->email)->hasSingleSession();
    }

    /** @test */
    public function it_can_destroy_single_session()
    {
        $user          = $this->getAUser();
        $singleSession = singleSession($user->email);

        $this->mockRememberCache($singleSession->getCacheKey(), config('single-session.duration'), $user);
        $this->mockForgetCache($singleSession->getCacheKey());
        $this->mockHasCache($singleSession->getCacheKey(), false);

        singleSession($user->email)->set();
        singleSession($user->email)->destroy();
        singleSession($user->email)->hasSingleSession();
    }

    /** @test */
    public function it_throw_exception_on_login_multiple_session()
    {
        $this->expectException(
            \CleaniqueCoders\LaravelSingleSession\Exceptions\SingleSessionException::class
        );

        $user          = $this->getAUser();
        $singleSession = singleSession($user->email);

        $this->mockRememberCache($singleSession->getCacheKey(), config('single-session.duration'), $user);
        $this->mockHasCache($singleSession->getCacheKey());

        singleSession($user->email)->set();
        singleSession($user->email)->validate();
    }

    private function mockRememberCache($key, $duration, $return)
    {
        return Cache::shouldReceive('remember')
            ->once()
            ->with(
                $key,
                $duration,
                Closure::class
            )->andReturn($return);
    }

    private function mockHasCache($key, $return = true)
    {
        return Cache::shouldReceive('has')
            ->once()
            ->with($key)
            ->andReturn($return);
    }

    private function mockForgetCache($key)
    {
        return Cache::shouldReceive('forget')
            ->once()
            ->with($key)
            ->andReturn(true);
    }
}

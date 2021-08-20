<?php

namespace YSRoot\SwaggerUI\Tests\Unit\Http\Middleware;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Orchestra\Testbench\TestCase;
use YSRoot\SwaggerUI\Http\Middleware\EnsureIsAuthorized;

class EnsureIsAuthorizedTest extends TestCase
{
    public function testLocalEnvMiddlewarePassed(): void
    {
        $this->app->detectEnvironment(fn() => 'local');
        $request = Request::create('not-important');
        $expectedResult = new Response(['expected' => 'expected']);
        $callback = fn () => $expectedResult;

        $result = (new EnsureIsAuthorized())->handle($request, $callback);

        $this->assertEquals($expectedResult->content(), $result->content());
    }
}
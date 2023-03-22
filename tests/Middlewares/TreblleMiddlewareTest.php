<?php

declare(strict_types=1);

namespace Treblle\Tests\Middlewares;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Treblle\Middlewares\TreblleMiddleware;
use Treblle\Tests\TestCase;

class TreblleMiddlewareTest extends TestCase
{
    public function getMiddleware(): TreblleMiddleware
    {
        return $this->app->make(
            abstract: TreblleMiddleware::class,
        );
    }

    public function testJobIsDispatched(): void
    {
        Http::fake();

        $this->getMiddleware()->handle(
            request: Request::create(
                uri: 'test',
            ),
            next: fn () => new Response(
                content: json_encode($this->fixture(
                    name: 'projects/create',
                ), JSON_THROW_ON_ERROR)
            ),
        );

        Http::assertSentCount(1);
    }
}

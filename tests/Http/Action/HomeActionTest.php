<?php

declare(strict_types=1);

namespace Tests\Http\Action;

use Rib\Http\Action\HomeAction;
use HttpSoft\Message\ServerRequest;
use HttpSoft\Response\HtmlResponse;
use HttpSoft\Response\JsonResponse;
use PHPUnit\Framework\TestCase;

class HomeActionTest extends TestCase
{
    public function testHandle(): void
    {
        $action = new HomeAction();
        $response = $action->handle(new ServerRequest());

        $expected = (string) (new HtmlResponse('<h1>/</h1>'))->getBody();

        $this->assertInstanceOf(HtmlResponse::class, $response);
        $this->assertSame($expected, (string) $response->getBody());
    }
}

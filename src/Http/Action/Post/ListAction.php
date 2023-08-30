<?php

declare(strict_types=1);

namespace Rib\Http\Action\Post;

use Rib\Model\Post\PostRepository;
use HttpSoft\Basis\Response\PrepareJsonDataTrait;
use HttpSoft\Response\JsonResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ListAction implements RequestHandlerInterface
{
    use PrepareJsonDataTrait;

    /**
     * @var PostRepository
     */
    private PostRepository $post;

    /**
     * @param PostRepository $post
     */
    public function __construct(PostRepository $post)
    {
        $this->post = $post;
    }

    /**
     * {@inheritDoc}
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new JsonResponse($this->prepareJsonData($this->post->findAll()));
    }
}

<?php

namespace YSRoot\SwaggerUI\Http\Controllers;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use YSRoot\SwaggerUI\Facades\Docs;

class SwaggerUIController
{
    public function docs(): Response
    {
        $path = config('swagger-ui.paths.docs');
        $filePath = base_path($path);

        if (!file_exists($filePath)) {
            throw new NotFoundHttpException(sprintf('Unable to locate documentation file at: "%s"', $filePath));
        }

        $content = Docs::content($filePath);

        return new Response($content, SymfonyResponse::HTTP_OK, [
            'Content-Type' => 'application/yaml',
            'Content-Disposition' => 'inline',
        ]);
    }

    public function api(): Response
    {
        return new Response(view('index', [
            'urlToDocs' => route(config('swagger-ui.routes.swagger', 'docs.swagger'))
        ]), SymfonyResponse::HTTP_OK);
    }
}

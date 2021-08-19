<?php

namespace YSRoot\SwaggerUI\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SwaggerUiAssetController
{
    /**
     * @throws NotFoundHttpException
     */
    public function __invoke(Request $request, string $asset): Response
    {
        try {
            $path = swagger_ui_dist_path($asset);

            return (new Response(file_get_contents($path), SymfonyResponse::HTTP_OK, [
                'Content-Type' => (pathinfo($asset))['extension'] == 'css'
                    ? 'text/css'
                    : 'application/javascript',
            ]))
                ->setSharedMaxAge(31536000)
                ->setMaxAge(31536000)
                ->setExpires(new DateTime('+1 year'));
        } catch (RuntimeException $exception) {
            throw new NotFoundHttpException($exception->getMessage());
        }
    }
}

<?php

namespace App\Infrastructure\Web\Symfony\Controller;

use App\Infrastructure\Ssr\Renderer;
use Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SsrController extends AbstractController
{
    /**
     * SSR engine for rendering
     *
     * @var Renderer
     */
    private $renderer;

    /**
     * Constructor
     *
     * @param Renderer $renderer
     */
    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * @Route("/{reactRoute}", name="ssr_index", defaults={"reactRoute": null})
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function index(Request $request)
    {
        $rendered = $this->renderer
            ->entry($this->getParameter('kernel.project_dir') . '/public/js/server.js')
            ->context('js_bundle', ['test1', 'test12', 'test123'])
            ->context('css_bundle', 'test1234')
            ->context('url', $request->getRequestUri())
            ->context('__global__', [
                'url' => [
                    'current' => $request->getUri(),
                    'full' => $request->getUri(),
                    'previous' => $request->getUri(),
                    'host' => $request->getSchemeAndHttpHost()
                ]
            ])
            ->fallback('<div id="app"></div>') // If ssr fails, we need a container to render the app client-side
            ->render();

        return new Response($rendered);
    }
}

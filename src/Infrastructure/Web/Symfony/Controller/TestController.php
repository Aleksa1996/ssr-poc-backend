<?php
namespace App\Infrastructure\Web\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/test", name="test_index")
     */
    public function index()
    {
        return new JsonResponse(['success' => true]);
    }
}

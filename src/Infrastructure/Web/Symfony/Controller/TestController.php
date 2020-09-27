<?php
namespace App\Infrastructure\Web\Symfony\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * @Route("/", name="test_index")
     */
    public function index()
    {
        return new JsonResponse(['success' => true, 'PERA' => $_SERVER['APP_TEST_ENV_VARIABLE'], 'hello' => 1111]);
    }

    /**
     * @Route("/test", name="test_test")
     */
    public function test()
    {
        return new JsonResponse(['success' => true]);
    }
}

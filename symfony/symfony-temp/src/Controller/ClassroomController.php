<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClassroomController extends AbstractController
{
    private string $file = __DIR__ . '/../../data/classrooms.json';


    #[Route('/classrooms', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $classrooms = json_decode(
            file_get_contents($this->file),
            true
        );

        return new JsonResponse($classrooms);
    }
}

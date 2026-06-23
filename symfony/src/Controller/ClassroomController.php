<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClassroomController extends AbstractController
{
    private string $file = __DIR__ . '/../../data/classrooms.json';


    // GET all classrooms
    #[Route('/classrooms', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $classrooms = $this->readData();

        return new JsonResponse($classrooms);
    }


    // GET classroom by id
    #[Route('/classrooms/{id}', methods: ['GET'])]
    public function show(string $id): JsonResponse
    {
        $classrooms = $this->readData();

        foreach ($classrooms as $classroom) {
            if ($classroom['id'] === $id) {
                return new JsonResponse($classroom);
            }
        }

        return new JsonResponse(
            ['message' => 'Classroom not found'],
            404
        );
    }


    // POST create classroom
    #[Route('/classrooms', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode(
            $request->getContent(),
            true
        );

        $classrooms = $this->readData();


        $newClassroom = [
            'id' => (string)(count($classrooms) + 1),
            'number' => $data['number'] ?? '',
            'building' => $data['building'] ?? '',
            'capacity' => $data['capacity'] ?? 0,
            'type' => $data['type'] ?? '',
            'is_available' => $data['is_available'] ?? true
        ];


        $classrooms[] = $newClassroom;

        $this->writeData($classrooms);


        return new JsonResponse(
            $newClassroom,
            201
        );
    }



    // PATCH update classroom
    #[Route('/classrooms/{id}', methods: ['PATCH'])]
    public function update(
        string $id,
        Request $request
    ): JsonResponse
    {

        $data = json_decode(
            $request->getContent(),
            true
        );


        $classrooms = $this->readData();


        foreach ($classrooms as &$classroom) {

            if ($classroom['id'] === $id) {


                foreach ($data as $key => $value) {

                    $classroom[$key] = $value;

                }


                $this->writeData($classrooms);


                return new JsonResponse($classroom);
            }
        }


        return new JsonResponse(
            ['message'=>'Classroom not found'],
            404
        );
    }



    // DELETE classroom
    #[Route('/classrooms/{id}', methods: ['DELETE'])]
    public function delete(string $id): JsonResponse
    {

        $classrooms = $this->readData();


        foreach ($classrooms as $key => $classroom) {


            if ($classroom['id'] === $id) {


                unset($classrooms[$key]);


                $classrooms = array_values($classrooms);


                $this->writeData($classrooms);


                return new JsonResponse(
                    null,
                    204
                );
            }
        }


        return new JsonResponse(
            ['message'=>'Classroom not found'],
            404
        );
    }



    private function readData(): array
    {
        return json_decode(
            file_get_contents($this->file),
            true
        );
    }



    private function writeData(array $data): void
    {
        file_put_contents(
            $this->file,
            json_encode(
                $data,
                JSON_PRETTY_PRINT
            )
        );
    }
}

<?php

declare(strict_types=1);

namespace App\Controller;

use App\Service\ParcelDelete;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ParcelDeleteController extends AbstractController
{
    #[OA\Delete(
        summary: 'Удаляет посылку по заданному id',
        tags: ['Parcel'],
        parameters: [new OA\Parameter(
            name: 'id',
            description: 'id посылки для удаления',
            in: 'path',
            schema: new OA\Schema(
                type: 'integer'
            )
        )],
        responses: [new OA\Response(
            response: 404,
            description: 'Посылка не найдена',
        )]
    )]
    #[Route('/api/parcel/{id}', name: 'app_parcel_delete', requirements: ['id' => '\d+'], methods: 'DELETE')]
    public function __invoke(int $id, ParcelDelete $parcelDelete): JsonResponse
    {
        return $parcelDelete->delete($id);
    }
}

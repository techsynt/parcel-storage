<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ParcelDto;
use App\Service\ParcelAdd;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class ParcelAddController extends AbstractController
{
    #[OA\Post(
        summary: 'Добавляет посылку по заданной json структуре',
        requestBody: new OA\RequestBody(
            description: 'Пример json запроса для добавления посылки',
            content: new OA\JsonContent(
                ref: new Model(type: ParcelDto::class)
            )
        ),
        tags: ['Parcel'],
        responses: [
            new OA\Response(
                response: 500,
                description: 'HTTP 500 Internal Server Error',
            ),
            new OA\Response(
                response: 200,
                description: 'Успешно добавлено',
            )]
    )]
    #[Route('/api/parcel', name: 'api_parcel_add', methods: 'POST')]
    public function __invoke(ParcelAdd $parcelAdd): JsonResponse
    {
        return $parcelAdd->add();
    }
}

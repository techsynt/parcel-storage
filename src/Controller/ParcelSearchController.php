<?php

declare(strict_types=1);

namespace App\Controller;

use App\Dto\ParcelDto;
use App\Service\ParcelSearch;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ParcelSearchController extends AbstractController
{
    #[OA\Get(
        summary: 'Поиск посылки',
        tags: ['Parcel'],
        parameters: [
            new OA\Parameter(
                name: 'searchType',
                description: 'Поле используется для определения типа поиска. Допустимые значения sender_phone и receiver_fullname',
                in: 'query',
                schema: new OA\Schema(type: 'string')
            ),
            new OA\Parameter(
                name: 'q',
                description: 'Поле используется для поиска по заданному значению.',
                in: 'query',
                schema: new OA\Schema(type: 'string')
            ),
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: 'Пример успешно возвращаемых данных',
                content: new OA\JsonContent(
                    type: 'array',
                    items: new OA\Items(ref: new Model(type: ParcelDto::class))
                )
            ),
            new OA\Response(
                response: 400,
                description: 'неверный запрос',
            ),
        ]
    )]
    #[Route('/api/parcel', name: 'app_parcel_search', methods: 'GET')]
    public function __invoke(ParcelSearch $parcelSearch, Request $request): JsonResponse
    {
        return match ($request->get('searchType')) {
            'sender_phone' => $this->json($parcelSearch->searchBySenderPhone($request->get('q'))),
            'receiver_fullname' => $this->json($parcelSearch->searchByRecipientFullName($request->get('q'))),
            default => throw new BadRequestHttpException('неверный запрос', null, 400)
        };
    }
}

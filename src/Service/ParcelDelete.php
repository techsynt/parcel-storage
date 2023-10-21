<?php

declare(strict_types=1);

namespace App\Service;

use App\Repository\ParcelRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ParcelDelete
{
    public EntityManagerInterface $em;
    public ParcelRepository $parcelRepository;

    public function __construct(EntityManagerInterface $em, ParcelRepository $parcelRepository)
    {
        $this->em = $em;
        $this->parcelRepository = $parcelRepository;
    }

    public function delete(int $id): JsonResponse
    {
        if (!$this->parcelRepository->find($id)) {
            throw new NotFoundHttpException('посылка с таким id не найдена', null, 404);
        } else {
            $this->em->remove($this->parcelRepository->find($id));
            $this->em->flush();
        }

        return new JsonResponse(['message' => 'Deleted Parcel with id '.$id]);
    }
}

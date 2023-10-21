<?php

declare(strict_types=1);

namespace App\Service;

use App\DataTransformer\ParcelTransformer;
use App\Dto\ParcelDto;
use App\Repository\FullNameRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

class ParcelAdd
{
    public Request $request;
    public SerializerInterface $serializer;
    public EntityManagerInterface $em;
    public ParcelTransformer $parcelTransformer;
    private FullNameRepository $fullNameRepository;

    public function __construct(
        Request $request,
        SerializerInterface $serializer,
        EntityManagerInterface $em,
        ParcelTransformer $parcelTransformer,
        FullNameRepository $fullNameRepository
    ) {
        $this->request = $request;
        $this->serializer = $serializer;
        $this->em = $em;
        $this->parcelTransformer = $parcelTransformer;
        $this->fullNameRepository = $fullNameRepository;
    }

    public function add(): JsonResponse
    {
        /** @var ParcelDto $parcelDto */
        $parcelDto = $this->serializer->deserialize($this->request->getContent(), ParcelDto::class, 'json');
        $senderDto = $parcelDto->sender;
        $recipientDto = $parcelDto->recipient;
        $senderFullName = $this->fullNameRepository->findOneBy([
            'firstName' => $senderDto->fullName->firstName,
            'middleName' => $senderDto->fullName->middleName,
            'lastName' => $senderDto->fullName->lastName,
        ]);
        $recipientFullName = $this->fullNameRepository->findOneBy([
            'firstName' => $recipientDto->fullName->firstName,
            'middleName' => $recipientDto->fullName->middleName,
            'lastName' => $recipientDto->fullName->lastName,
        ]);

        $parcel = $this->parcelTransformer->fromDtoToEntity($parcelDto);

        if (null !== $senderFullName) {
            $parcel->setSender($senderFullName->getSender());
        }
        if (null !== $recipientFullName) {
            $parcel->setRecipient($recipientFullName->getRecipient());
        }

        $this->em->persist($parcel);
        $this->em->flush();

        return new JsonResponse(['message' => 'Успешно добавлено']);
    }
}

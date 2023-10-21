<?php

declare(strict_types=1);

namespace App\Service;

use App\DataTransformer\ParcelTransformer;
use App\Repository\FullNameRepository;
use App\Repository\RecipientRepository;
use App\Repository\SenderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;

class ParcelSearch
{
    public function __construct(
        public EntityManagerInterface $em,
        public SerializerInterface $serializer,
        public ParcelTransformer $parcelTransformer,
        public SenderRepository $senderRepository,
        public FullNameRepository $fullNameRepository,
        public RecipientRepository $recipientRepository,
    ) {
    }

    public function searchBySenderPhone($phone): iterable
    {
        $sender = $this->senderRepository->findOneBy(['phone' => $phone]);
        if (null != $sender) {
            return $this->parcelTransformer->fromEntityToDto($sender->getParcels());
        }

        return [''];
    }

    public function searchByRecipientFullName($fullname): iterable
    {
        $nameParts = explode(' ', $fullname);
        if (3 == \count($nameParts, \COUNT_NORMAL)) {
            $recipient = $this->fullNameRepository->findOneBy([
                'lastName' => $nameParts[0],
                'firstName' => $nameParts[1],
                'middleName' => $nameParts[2],
                ]);
            if (null != $recipient) {
                return $this->parcelTransformer->fromEntityToDto($recipient->getRecipient()->getParcels());
            }
        }

        return [''];
    }
}

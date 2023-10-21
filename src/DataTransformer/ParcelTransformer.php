<?php

declare(strict_types=1);

namespace App\DataTransformer;

use App\Dto\ParcelDto;
use App\Entity\Parcel;

class ParcelTransformer
{
    public function __construct(
        public readonly SenderTransformer $senderTransformer,
        public readonly RecipientTransformer $recipientTransformer,
        public readonly DimensionTransformer $dimensionsTransformer,
        public Parcel $parcel
    ) {
    }

    public function fromDtoToEntity(ParcelDto $parcelDto): Parcel
    {
        $parcel = new Parcel();
        $parcel->setSender($this->senderTransformer->fromDtoToEntity($parcelDto->sender));
        $parcel->setRecipient($this->recipientTransformer->fromDtoToEntity($parcelDto->recipient));
        $parcel->setDimensions($this->dimensionsTransformer->fromDtoToEntity($parcelDto->dimensions));
        $parcel->setEstimatedCost($parcelDto->estimatedCost);

        return $parcel;
    }

    public function fromEntityToDto(iterable $objects): iterable
    {
        $dto = [];
        foreach ($objects as $object) {
            $object = new ParcelDto(
                $object->getId(),
                $this->senderTransformer->fromEntityToDto($object->getSender()),
                $this->recipientTransformer->fromEntityToDto($object->getRecipient()),
                $this->dimensionsTransformer->fromEntityToDto($object->getDimensions()),
                $object->getEstimatedCost(),
            );
            $dto[] = $object;
        }

        return $dto;
    }
}

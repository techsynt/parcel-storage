<?php

declare(strict_types=1);

namespace App\DataTransformer;

use App\Dto\Sender as SenderDto;
use App\Entity\Sender;

class SenderTransformer
{
    public AddressTransformer $addressTransformer;
    public FullNameTransformer $fullNameTransformer;

    public function __construct(AddressTransformer $addressTransformer, FullNameTransformer $fullNameTransformer)
    {
        $this->addressTransformer = $addressTransformer;
        $this->fullNameTransformer = $fullNameTransformer;
    }

    public function fromDtoToEntity(SenderDto $senderDto): Sender
    {
        $sender = new Sender();
        $sender->setFullName($this->fullNameTransformer->fromDtoToEntity($senderDto->fullName));
        $sender->setPhone($senderDto->phone);
        $sender->setAddress($this->addressTransformer->fromDtoToEntity($senderDto->address));

        return $sender;
    }

    public function fromEntityToDto(Sender $sender): SenderDto
    {
        return new SenderDto(
            $this->fullNameTransformer->fromEntityToDto($sender->getFullName()),
            $sender->getPhone(),
            $this->addressTransformer->fromEntityToDto($sender->getAddress()),
        );
    }
}

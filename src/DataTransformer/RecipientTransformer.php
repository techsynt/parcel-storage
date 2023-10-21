<?php

namespace App\DataTransformer;

use App\Dto\Recipient as RecipientDto;
use App\Entity\Recipient;

class RecipientTransformer
{
    public $addressTransformer;
    public $fullNameTransformer;
    public Recipient $recipient;
    public function __construct(AddressTransformer $addressTransformer, FullNameTransformer $fullNameTransformer, Recipient $recipient)
    {
        $this->recipient = $recipient;
        $this->addressTransformer = $addressTransformer;
        $this->fullNameTransformer = $fullNameTransformer;
    }

    public function fromDtoToEntity(RecipientDto $recipientDto): Recipient
    {
        $recipient = new Recipient();

        $recipient->setFullName($this->fullNameTransformer->fromDtoToEntity($recipientDto->fullName));
        $recipient->setPhone($recipientDto->phone);
        $recipient->setAddress($this->addressTransformer->fromDtoToEntity($recipientDto->address));


        return $recipient;
    }

    public function fromEntityToDto(Recipient $recipient): RecipientDto
    {
        return new RecipientDto(
            $this->fullNameTransformer->fromEntityToDto($recipient->getFullName()),
            $recipient->getPhone(),
            $this->addressTransformer->fromEntityToDto($recipient->getAddress())
        );
    }
}

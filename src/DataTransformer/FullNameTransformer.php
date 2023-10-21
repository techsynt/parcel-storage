<?php

declare(strict_types=1);

namespace App\DataTransformer;

use App\Dto\FullName as FullNameDto;
use App\Entity\FullName;

class FullNameTransformer
{
    public FullName $fullName;

    public function __construct(FullName $fullName)
    {
        $this->fullName = $fullName;
    }

    public function fromDtoToEntity(FullNameDto $fullNameDto): FullName
    {
        $fullName = new FullName();
        $fullName->setFirstName($fullNameDto->firstName);
        $fullName->setMiddleName($fullNameDto->middleName);
        $fullName->setLastName($fullNameDto->lastName);

        return $fullName;
    }

    public function fromEntityToDto(FullName $fullName): FullNameDto
    {
        return new FullNameDto(
            $fullName->getLastName(),
            $fullName->getFirstName(),
            $fullName->getMiddleName()
        );
    }
}

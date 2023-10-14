<?php
declare(strict_types=1);
namespace App\Dto;


final class Address
{
    public function __construct(
        public readonly string $County,
        public readonly string $City,
        public readonly string $Street,
        public readonly ?string $HouseNumber,
        public readonly ?string $ApartmentNumber
    ) {
    }
}
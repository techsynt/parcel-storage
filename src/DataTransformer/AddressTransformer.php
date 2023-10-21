<?php

namespace App\DataTransformer;

use App\Entity\Address;
use App\Dto\Address As AddressDto;
class AddressTransformer
{
    public Address $address;

    /**
     * @param Address $address
     */
    public function __construct(Address $address)
    {
        $this->address = $address;
    }

    public function fromDtoToEntity(AddressDto $addressDto): Address
    {
        $address = new Address();
        $address->setApartmentNumber($addressDto->apartmentNumber);
        $address->setCity($addressDto->city);
        $address->setCountry($addressDto->country);
        $address->setHouseNumber($addressDto->houseNumber);
        $address->setStreet($addressDto->street);

        return $address;
    }

    /**
     * @param Address $address
     * @return AddressDto
     */
    public function fromEntityToDto(Address $address): AddressDto
    {
        return new AddressDto(
            $address->getCountry(),
            $address->getCity(),
            $address->getStreet(),
            $address->getHouseNumber(),
            $address->getApartmentNumber()
        );
    }
}

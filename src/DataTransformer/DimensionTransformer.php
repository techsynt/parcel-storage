<?php

namespace App\DataTransformer;

use App\Entity\Dimensions;
use App\Dto\Dimensions as DimensionsDto;

class DimensionTransformer
{
    public Dimensions $dimensions;

    /**
     * @param Dimensions $dimensions
     */
    public function __construct(Dimensions $dimensions)
    {
        $this->dimensions = $dimensions;
    }

    public function fromDtoToEntity(DimensionsDto $dimensionsDto): Dimensions
    {
        $dimensions = new Dimensions();
        $dimensions->setHeight($dimensionsDto->height);
        $dimensions->setLength($dimensionsDto->length);
        $dimensions->setWeight($dimensionsDto->weight);
        $dimensions->setWidth($dimensionsDto->width);

        return $dimensions;
    }

    public function fromEntityToDto(Dimensions $dimensions): DimensionsDto
    {
        return new DimensionsDto(
            $dimensions->getWeight(),
            $dimensions->getLength(),
            $dimensions->getHeight(),
            $dimensions->getWidth(),
        );
    }
}

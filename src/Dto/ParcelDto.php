<?php

declare(strict_types=1);

namespace App\Dto;

final class ParcelDto
{
    public function __construct(
        public readonly ?int $id,
        public readonly Sender $sender,
        public readonly Recipient $recipient,
        public readonly Dimensions $dimensions,
        public readonly int $estimatedCost
    ) {
    }
}

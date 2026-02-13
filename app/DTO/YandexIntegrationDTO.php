<?php

namespace App\DTO;

readonly class YandexIntegrationDTO
{
    public function __construct(
        public string $org_name,
        public float  $rating,
        public int    $reviews_count,
        public array  $reviews,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            org_name: $data['org_name'],
            rating: (float) $data['rating'],
            reviews_count: (int) $data['reviews_count'],
            reviews: $data['reviews'],
        );
    }
}

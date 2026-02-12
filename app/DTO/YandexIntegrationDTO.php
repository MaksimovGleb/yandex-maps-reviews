<?php

namespace App\DTO;

readonly class YandexIntegrationDTO
{
    public function __construct(
        public string $name,
        public float  $rating,
        public int    $reviews_count,
        public array  $reviews,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            rating: (float) $data['rating'],
            reviews_count: (int) $data['reviews_count'],
            reviews: $data['reviews'],
        );
    }
}

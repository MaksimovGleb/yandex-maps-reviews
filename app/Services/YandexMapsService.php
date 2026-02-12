<?php

namespace App\Services;

use App\Actions\GetYandexReviewsAction;
use App\Actions\UpdateCompanyAction;
use App\DTO\YandexIntegrationDTO;
use App\Models\User;

class YandexMapsService
{
    public function __construct(
        protected GetYandexReviewsAction $getReviewsAction,
        protected UpdateCompanyAction $updateCompanyAction
    ) {}

    public function getReviews(string $url): YandexIntegrationDTO
    {
        return $this->getReviewsAction->execute($url);
    }

    public function saveIntegration(User $user, string $url)
    {
        return $this->updateCompanyAction->execute($user, $url);
    }
}

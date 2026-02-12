<?php

namespace App\Actions;

use App\Models\User;
use App\Models\Company;

class UpdateCompanyAction
{
    public function execute(User $user, string $yandexUrl): Company
    {
        return $user->company()->updateOrCreate(
            ['user_id' => $user->id],
            ['yandex_url' => $yandexUrl]
        );
    }
}

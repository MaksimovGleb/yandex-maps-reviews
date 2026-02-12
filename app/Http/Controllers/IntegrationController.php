<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIntegrationRequest;
use App\Services\YandexMapsService;
use Inertia\Inertia;

class IntegrationController extends Controller
{
    public function reviews(YandexMapsService $service)
    {
        $company = auth()->user()->company;
        $data = null;

        if ($company && $company->yandex_url) {
            try {
                $data = $service->getReviews($company->yandex_url);
            } catch (\Exception $e) {
                session()->flash('error', 'Не удалось загрузить отзывы: ' . $e->getMessage());
            }
        }

        return Inertia::render('Integration/Reviews', [
            'yandexData' => $data,
        ]);
    }

    public function settings()
    {
        return Inertia::render('Integration/Settings', [
            'company' => auth()->user()->company,
        ]);
    }

    public function store(StoreIntegrationRequest $request, YandexMapsService $service)
    {
        $service->saveIntegration(auth()->user(), $request->validated()['yandex_url']);

        return redirect()->route('reviews.index')->with('status', 'Настройки сохранены');
    }
}

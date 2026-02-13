<?php

namespace App\Actions;

use App\DTO\YandexIntegrationDTO;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class GetYandexReviewsAction
{
    public function execute(string $url): YandexIntegrationDTO
    {
        $id = $this->extractOrgId($url);
        
        if (!$id) {
            throw new \Exception('Не удалось определить ID организации из ссылки');
        }

        $headers = [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
            'Accept-Language' => 'ru-RU',
        ];

        // 1. Данные из HTML
        $html = Http::withHeaders($headers)->get($url)->body();
        preg_match('/<h1[^>]*>(.*?)<\/h1>/', $html, $m1);
        preg_match('/"ratingValue":\s*"?([\d\.]+)"?/', $html, $m2);
        preg_match('/"reviewCount":\s*"?(\d+)"?/', $html, $m3);

        $name = html_entity_decode(trim(strip_tags($m1[1] ?? 'Организация')), ENT_QUOTES);
        $rating = (float)($m2[1] ?? 0);
        $count = (int)($m3[1] ?? 0);

        // 2. Отзывы (виджет или JSON-фоллбэк)
        $res = Http::withHeaders($headers + ['Referer' => "https://yandex.ru/maps-reviews-widget/v1/?businessId=$id"])
            ->get("https://yandex.ru/maps-reviews-widget/v1/getReviews?businessId=$id&pageSize=50");

        $raw = $res->json()['reviews'] ?? [];

        if (empty($raw) && preg_match_all('/<script type="application\/json" class="[^"]*">(.+?)<\/script>/s', $html, $ms)) {
            foreach ($ms[1] as $json) {
                if (($d = json_decode($json, true)) && ($f = $this->findReviews($d))) {
                    $raw = $f; break;
                }
            }
        }

        $mapped = array_map(fn($i) => [
            'author_name' => $i['author']['name'] ?? 'Аноним',
            'text' => html_entity_decode(trim((string)(is_array($i['text'] ?? '') ? ($i['text']['ru'] ?? array_shift($i['text'])) : ($i['text'] ?? ''))), ENT_QUOTES),
            'rating' => $i['rating'] ?? 0,
            'published_at' => isset($i['updatedTime']) ? date('Y-m-d H:i:s', strtotime($i['updatedTime'])) : now()->toDateTimeString(),
            'external_id' => $i['reviewId'] ?? Str::random(10),
        ], $raw);

        return new YandexIntegrationDTO($name, round($rating, 1), $count, $mapped);
    }

    private function findReviews(array $d): array
    {
        if (isset($d[0]['author']) || isset($d[0]['reviewId'])) return $d;
        foreach ($d as $k => $v) {
            if (is_array($v) && !in_array($k, ['hours', 'translations'])) {
                if ($r = $this->findReviews($v)) return $r;
            }
        }
        return [];
    }

    private function extractOrgId(string $url): ?string
    {
        return preg_match('/\/(\d{8,12})\/?/', $url, $m) ? $m[1] : null;
    }
}

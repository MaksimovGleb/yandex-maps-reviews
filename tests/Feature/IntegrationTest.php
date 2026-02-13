<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_settings_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('settings.edit'));

        $response->assertOk();
    }

    public function test_reviews_page_is_displayed(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->get(route('reviews.index'));

        $response->assertOk();
    }

    public function test_yandex_url_can_be_saved(): void
    {
        $user = User::factory()->create();
        $yandexUrl = 'https://yandex.ru/maps/org/1010501395/reviews/';

        $response = $this
            ->actingAs($user)
            ->post(route('settings.store'), [
                'yandex_url' => $yandexUrl,
            ]);

        $response->assertRedirect(route('reviews.index'));

        $this->assertDatabaseHas('companies', [
            'user_id' => $user->id,
            'yandex_url' => $yandexUrl,
        ]);
    }

    public function test_invalid_yandex_url_is_rejected(): void
    {
        $user = User::factory()->create();

        $response = $this
            ->actingAs($user)
            ->post(route('settings.store'), [
                'yandex_url' => 'not-a-url',
            ]);

        $response->assertSessionHasErrors('yandex_url');
    }
}

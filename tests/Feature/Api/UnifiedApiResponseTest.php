<?php

declare(strict_types=1);

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class UnifiedApiResponseTest extends TestCase
{
    use RefreshDatabase;

    public function test_validation_failure_returns_unified_response_structure(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->postJson('/api/v1/buildings', []);

        $response
            ->assertStatus(422)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
                'errors',
            ])
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Validation failed.')
            ->assertJsonPath('data', null);

        $this->assertIsArray($response->json('errors'));
    }

    public function test_unauthenticated_access_returns_unified_response_structure(): void
    {
        $response = $this->getJson('/api/v1/buildings');

        $response
            ->assertStatus(401)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
                'errors',
            ])
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Unauthenticated.')
            ->assertJsonPath('data', null);
    }

    public function test_model_not_found_returns_unified_response_structure(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $response = $this->getJson('/api/v1/buildings/999999');

        $response
            ->assertStatus(404)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
                'errors',
            ])
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Resource not found.')
            ->assertJsonPath('data', null);
    }

    public function test_login_failure_returns_unified_response_structure(): void
    {
        $user = User::factory()->create([
            'email' => 'tester@example.com',
            'password' => 'password',
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $response
            ->assertStatus(401)
            ->assertJsonStructure([
                'success',
                'message',
                'data',
                'errors',
            ])
            ->assertJsonPath('success', false)
            ->assertJsonPath('message', 'Invalid credentials.')
            ->assertJsonPath('data', null)
            ->assertJsonPath('errors', null);
    }

    public function test_login_success_returns_unified_response_payload_shape(): void
    {
        $user = User::factory()->create([
            'email' => 'tester@example.com',
            'password' => 'password',
        ]);

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    'token',
                    'token_type',
                    'user' => [
                        'id',
                        'name',
                        'email',
                        'has_fcm_token',
                    ],
                ],
                'errors',
            ])
            ->assertJsonPath('success', true)
            ->assertJsonPath('message', 'Login successful.')
            ->assertJsonPath('data.token_type', 'Bearer')
            ->assertJsonPath('data.user.email', $user->email)
            ->assertJsonPath('data.user.has_fcm_token', false)
            ->assertJsonPath('errors', null);
    }

    public function test_login_with_optional_fcm_token_persists_and_returns_has_fcm_token(): void
    {
        $user = User::factory()->create([
            'email' => 'fcm-tester@example.com',
            'password' => 'password',
            'fcm_token' => null,
        ]);

        $deviceToken = 'test-fcm-token-from-flutter-login';

        $response = $this->postJson('/api/v1/login', [
            'email' => $user->email,
            'password' => 'password',
            'fcm_token' => $deviceToken,
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonPath('data.user.has_fcm_token', true);

        $this->assertSame($deviceToken, $user->fresh()->fcm_token);
    }
}

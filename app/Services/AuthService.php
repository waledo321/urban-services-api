<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @param  array{email: string, password: string, device_name?: string|null}  $credentials
     * @return array{token: string, token_type: string, user: User}
     */
    public function login(array $credentials): array
    {
        $user = User::query()->where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            abort(401, 'Invalid credentials.');
        }

        $deviceName = $credentials['device_name'] ?? 'api-client';
        $token = $user->createToken($deviceName)->plainTextToken;

        return [
            'token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }
}

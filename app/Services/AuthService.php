<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    /**
     * @param  array{email: string, password: string, fcm_token?: string|null}  $credentials
     * @return array{token: string, token_type: string, user: User}
     */
    public function login(array $credentials): array
    {
        $user = User::query()->where('email', $credentials['email'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            abort(401, 'Invalid credentials.');
        }

        $fcmToken = $credentials['fcm_token'] ?? null;
        if (is_string($fcmToken) && $fcmToken !== '') {
            $user->forceFill(['fcm_token' => $fcmToken])->save();
        }

        $token = $user->createToken('mobile-app')->plainTextToken;

        $user->refresh();

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

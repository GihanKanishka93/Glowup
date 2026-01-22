<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $credentials = $request->validate([
            'user_name' => ['required', 'string'],
            'password' => ['required', 'string'],
            'device_name' => ['sometimes', 'string', 'max:255'],
        ]);

        $user = User::with(['roles', 'permissions'])->where('user_name', $credentials['user_name'])->first();

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            return response()->json([
                'message' => 'The provided credentials are invalid.',
            ], 422);
        }

        if (method_exists($user, 'trashed') && $user->trashed()) {
            return response()->json([
                'message' => 'This account has been suspended. Please contact an administrator.',
            ], 403);
        }

        $deviceName = $credentials['device_name'] ?? 'spa';

        $user->tokens()->where('name', $deviceName)->delete();

        $abilities = $this->resolveAbilities($user);
        $plainTextToken = $user->createToken($deviceName, $abilities);

        return response()->json($this->tokenPayload($user, $plainTextToken->plainTextToken, $abilities), 201);
    }

    public function logout(Request $request): JsonResponse
    {
        $token = $request->user()?->currentAccessToken();

        if ($token) {
            $token->delete();
        }

        return response()->json([
            'message' => 'Logged out successfully.',
        ]);
    }

    public function refresh(Request $request): JsonResponse
    {
        $user = $request->user();
        $deviceName = $request->input('device_name', optional($request->user()?->currentAccessToken())->name ?? 'spa');

        if ($token = $user?->currentAccessToken()) {
            $token->delete();
        }

        $abilities = $this->resolveAbilities($user);
        $plainTextToken = $user->createToken($deviceName, $abilities);

        return response()->json($this->tokenPayload($user, $plainTextToken->plainTextToken, $abilities));
    }

    private function resolveAbilities(User $user): array
    {
        $permissions = $user->getAllPermissions()->pluck('name')->filter()->values()->all();

        if (! empty($permissions)) {
            return $permissions;
        }

        return $user->getRoleNames()->map(fn (string $role) => 'role:' . $role)->values()->all();
    }

    private function tokenPayload(User $user, string $token, array $abilities): array
    {
        $expiration = config('sanctum.expiration');
        $expiresAt = $expiration ? Carbon::now()->addMinutes($expiration) : null;

        return [
            'token' => $token,
            'token_type' => 'Bearer',
            'abilities' => $abilities,
            'expires_at' => $expiresAt?->toIso8601String(),
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'user_name' => $user->user_name,
                'email' => $user->email,
                'roles' => $user->getRoleNames()->values()->all(),
                'permissions' => $user->getAllPermissions()->pluck('name')->values()->all(),
                'status' => $user->status,
                'theme' => $user->theme,
            ],
        ];
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserPreferenceController extends Controller
{
    public function updateTheme(Request $request): JsonResponse
    {
        $request->validate([
            'theme' => 'required|in:light,dark',
        ]);

        $user = $request->user();
        $user->theme = $request->input('theme');
        $user->save();

        return response()->json([
            'theme' => $user->theme,
            'message' => 'Theme preference updated',
        ]);
    }

    public function updateStatus(Request $request): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:available,in_consult,offline',
        ]);

        $user = $request->user();
        $user->status = $request->input('status');
        $user->save();

        return response()->json([
            'status' => $user->status,
            'message' => 'Status updated',
        ]);
    }
}

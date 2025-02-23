<?php

namespace App\Services;

use App\Http\Requests\UpdateProfileRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfileService
{
    public function getProfile(): JsonResponse
    {
        return response()->json([
            "data" => Auth::user()
        ]);
    }

    public function showPublicProfile(String $username): JsonResponse
    {
        $user = User::where("username", $username)->first();

        if (!$user) {
            return response()->json([
                "message" => "user not found",
            ], 404);
        }

        $links = DB::table("links")
            ->select(['id', 'platform', 'link'])
            ->where("user_id", $user->id)
            ->get();

        return response()->json([
            "data" => [
                "user" => $user,
                "links" => $links
            ]
        ]);
    }

    public function updateProfile(UpdateProfileRequest $data): JsonResponse
    {
        $user = Auth::user();
        $file = $data->file('profilePicture');
        $filePath = null;
        if (!is_null($file)) {
            $fileName = time() . '_' . $file->getFilename() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('images', $fileName, 'public');
        }

        DB::table('users')
            ->where('id', $user->id)
            ->update([
                'username' => $data['username'],
                'first_name' => $data['firstName'],
                'last_name' => $data['lastName'],
                'bio' => $data['bio'],
                'profile_picture_url' => is_null($filePath) ? $user->profile_picture_url : $filePath,
            ]);

        return response()->json([
            "message" => "success",
        ]);
    }
}

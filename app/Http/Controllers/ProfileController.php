<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        return response()->json([
            "data" => $request->user()
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            "firstName" => ["required", "string", "max:100"],
            "lastName" => ["required", "string", "max:100"],
            "email" => ["required", "string", "email"],
            "bio" => ["nullable", "string", "max:255"],
            "profilePictureUrl" => ["string", "url", "nullable"]
        ]);

        $user = User::find($request->user()->id);

        $user["first_name"] = $validated["firstName"];
        $user["last_name"] = $validated["lastName"];
        $user->email = $validated["email"];
        $user->bio = $validated["bio"];
        $user["profile_picture_url"] = $validated["profilePictureUrl"];
        $user->save();

        return response()->json([
            "message" => "success",
        ]);
    }

    public function showPublicProfile(Request $request)
    {
        $user = User::where("username", $request->username)->first();

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
}

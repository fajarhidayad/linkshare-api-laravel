<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class LinkController extends Controller
{
    public function show(Request $request)
    {
        $userId = $request->user()->id;

        $links = DB::table("links")
            ->where('user_id', $userId)
            ->get();

        return response()->json([
            "data" => $links
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            "platform" => ["required", "string", "max:100"],
            "link" => ["required", "string", "url:http,https"],
        ]);

        $link = Link::create([
            'platform' => $request->platform,
            'link' => $request->link,
            'user_id' => $request->user()->id,
        ]);

        return response()->json(null, 201);
    }

    public function destroy(Request $request)
    {
        $deleted = DB::table("links")
            ->where("id", $request->id)
            ->delete();

        if ($deleted < 1) {
            return response(null, 404)
                ->json([
                    "message" => "data not found"
                ]);
        }

        return response()->json([
            "message" => 'success'
        ]);
    }
}

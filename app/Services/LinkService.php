<?php

namespace App\Services;

use App\Models\Link;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LinkService
{
    public function getLinks(): JsonResponse
    {
        $links = Link::where('user_id', Auth::id())->get();
        return response()->json([
            'data' => $links
        ]);
    }

    public function getLink(int $id)
    {
        $link = Link::where('id', $id)->first();
        if (!$link) {
            return null;
        }

        return $link;
    }

    public function createLink(array $data): JsonResponse
    {
        $data['user_id'] = Auth::id();
        Link::create($data);
        return response()->json([], JsonResponse::HTTP_CREATED);
    }

    public function updateLink(array $data): JsonResponse
    {
        $user = Auth::user();

        DB::transaction(function () use ($user, $data) {
            DB::table('links')->where('user_id', '=', $user->id)->delete();

            $linksData = array_map(function ($link) use ($user) {
                return [
                    'user_id' => $user->id,
                    'url' => $link['url'],
                    'platform' => $link['platform'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            }, $data['links']);

            DB::table('links')->insert($linksData);
        });

        return response()->json([
            'message' => 'success'
        ], JsonResponse::HTTP_ACCEPTED);
    }

    public function deleteLink(int $id): JsonResponse
    {
        $link = $this->getLink($id);
        if (!$link) {
            return response()->json([
                'message' => 'Link not found'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $link->delete();

        return response()->json([
            'message' => 'success'
        ], JsonResponse::HTTP_ACCEPTED);
    }
}

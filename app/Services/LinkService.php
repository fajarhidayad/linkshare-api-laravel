<?php

namespace App\Services;

use App\Models\Link;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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

    public function updateLink(int $id, array $data): JsonResponse
    {
        $link = $this->getLink($id);
        if (!$link) {
            return response()->json([
                'message' => 'Link not found'
            ], JsonResponse::HTTP_NOT_FOUND);
        }

        $link->update($data);
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

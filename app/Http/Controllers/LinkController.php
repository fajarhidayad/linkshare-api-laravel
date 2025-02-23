<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Services\LinkService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    protected $linkService;

    public function __construct(LinkService $linkService)
    {
        $this->linkService = $linkService;
    }

    public function show(): JsonResponse
    {
        return $this->linkService->getLinks();
    }

    public function create(StoreLinkRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->linkService->createLink($data);
    }

    public function update(StoreLinkRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->linkService->updateLink($data);
    }

    public function destroy(Request $request): JsonResponse
    {
        return $this->linkService->deleteLink($request->id);
    }
}

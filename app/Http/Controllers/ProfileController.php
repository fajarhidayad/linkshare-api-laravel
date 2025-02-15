<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function show(): JsonResponse
    {
        return $this->profileService->getProfile();
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->profileService->updateProfile($data);
    }

    public function showPublicProfile(Request $request): JsonResponse
    {
        return $this->profileService->showPublicProfile($request->username);
    }
}

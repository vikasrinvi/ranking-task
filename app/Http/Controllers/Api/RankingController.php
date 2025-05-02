<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitRankingRequest;
use App\Models\UserRanking;
use App\Services\RankingService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class RankingController extends Controller
{
    public function __construct(protected RankingService $rankingService) {}

    public function submit(SubmitRankingRequest $request): JsonResponse
    {
        $this->rankingService->submit($request->validated()['rankings'], auth()->id());

        return response()->json(['message' => 'Your rankings have been saved.']);
    }

    public function myRankings(): JsonResponse
    {
        $rankings = $this->rankingService->getUserRankings(auth()->id());

        return response()->json(['data' => $rankings]);
    }
}

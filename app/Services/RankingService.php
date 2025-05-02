<?php

namespace App\Services;

use App\Models\UserRanking;
use Illuminate\Support\Facades\DB;

class RankingService
{
    public function submit(array $rankings, int $userId): void
    {
        DB::transaction(function () use ($rankings, $userId) {
            UserRanking::where('user_id', $userId)->delete();

            $insertData = collect($rankings)->map(function ($item) use ($userId) {
                return [
                    'user_id' => $userId,
                    'player_id' => $item['player_id'],
                    'rank' => $item['rank'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            UserRanking::insert($insertData);
        });
    }

    public function getUserRankings(int $userId)
    {
        return UserRanking::with('player')
            ->where('user_id', $userId)
            ->orderBy('rank')
            ->get();
    }
}

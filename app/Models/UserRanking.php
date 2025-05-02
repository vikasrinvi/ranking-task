<?php

namespace App\Models;

use App\Models\Player;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRanking extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'player_id', 'rank'];

    public function player()
    {
        return $this->belongsTo(Player::class);
    }
}

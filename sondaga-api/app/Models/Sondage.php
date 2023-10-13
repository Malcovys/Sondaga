<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Sondage extends Model
{
    use HasFactory;

    protected $fillable = [
        'titre',
        'options',
        'user_id',
    ];

    public function votes(): HasMany {

        return $this->hasMany(Vote::class);
    }
}
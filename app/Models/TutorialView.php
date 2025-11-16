<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorialView extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'tutorial_id',
        'user_id',
        'ip_address',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    /**
     * Relation avec le tutoriel
     */
    public function tutorial()
    {
        return $this->belongsTo(Tutorial::class);
    }

    /**
     * Relation avec l'utilisateur
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tutorial extends Model
{
    use HasFactory;

    protected $fillable = [
        'branch_id',
        'user_id',
        'title',
        'slug',
        'description',
        'content',
        'file_type',
        'file_path',
        'video_url',
        'file_size',
        'thumbnail',
        'is_published',
        'published_at',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'file_size' => 'integer',
        'views_count' => 'integer',
    ];

    /**
     * Relation avec la branche
     */
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    /**
     * Relation avec l'auteur
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relation avec les tags
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    /**
     * Relation avec les vues
     */
    public function views()
    {
        return $this->hasMany(TutorialView::class);
    }

    /**
     * Scope pour les tutoriels publiés
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    /**
     * Scope pour filtrer par branche
     */
    public function scopeByBranch($query, $branchId)
    {
        return $query->where('branch_id', $branchId);
    }

    /**
     * Générer automatiquement le slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($tutorial) {
            if (empty($tutorial->slug)) {
                $tutorial->slug = Str::slug($tutorial->title);
            }
        });
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'icon',
        'parent_id',
    ];

    // Relation : une branche appartient à une branche parente
    public function parent()
    {
        return $this->belongsTo(Branch::class, 'parent_id');
    }

    // Relation : une branche a plusieurs sous-branches
    public function children()
    {
        return $this->hasMany(Branch::class, 'parent_id');
    }

    // Relation : tutoriels de la branche
    public function tutorials()
    {
        return $this->hasMany(Tutorial::class);
    }

    // Relation : utilisateurs de la branche
    public function users()
    {
        return $this->hasMany(User::class);
    }

    // Méthode helper : vérifier si c'est une branche parente
    public function isParent()
    {
        return $this->children()->count() > 0;
    }

    // Méthode helper : obtenir toutes les branches avec leurs enfants
    public static function getAllWithChildren()
    {
        return self::whereNull('parent_id')->with('children')->get();
    }
}
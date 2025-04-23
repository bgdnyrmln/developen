<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'color']; // allow mass-assignment if needed

    public function exercises()
    {
        return $this->belongsToMany(Exercise::class, 'category_exercise');
    }
}

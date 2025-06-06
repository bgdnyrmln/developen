<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Exercise extends Model
{

    protected $guarded = [];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_exercise');
    }

}

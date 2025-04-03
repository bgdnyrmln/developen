<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $table = 'cars';
    protected $guarded = [];

    // Corrected Driver Relationship (A Car belongs to ONE Driver)
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function tag(string $name)
    {
        $tag = Tag::firstOrCreate(['name' => $name]);
        $this->tags()->attach($tag);
    }

    // Corrected Tags Relationship (Many-to-Many with the correct pivot table)
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'car_tags', 'car_id', 'tag_id');
    }
}



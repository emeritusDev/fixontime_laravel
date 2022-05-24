<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Learning extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'url',
        'thumbnail',
    ];

    protected function thumbnail(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => config('app.url')."/storage/".$value,
        );
    }
}

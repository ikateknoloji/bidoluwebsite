<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_url',
        'image_width',
        'image_height',
        'image_alt_text',
        'image_caption',
        'redirect_url',
    ];

    /**
     * The tags that belong to the project.
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}

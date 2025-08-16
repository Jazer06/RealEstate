<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'address',
        'user_id',
        'image_path',
        'area',
        'rooms',
        'type',
         'slider_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'property_id', 'user_id')->withTimestamps();
    }
    
    public function slider()
    {
        return $this->belongsTo(Slider::class);
    }
    
    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }
}
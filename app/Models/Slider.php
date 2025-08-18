<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'button_text',
        'button_link',
        'image_path',
    ];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function images()
    {
        return $this->hasMany(SliderImage::class);
    }
}
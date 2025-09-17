<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $table = 'property_images';

    protected $fillable = ['property_id', 'image_path', 'alt_text', 'created_by', 'updated_by'];

    public $timestamps = true;

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

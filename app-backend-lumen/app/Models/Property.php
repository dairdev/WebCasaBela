<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $table = 'properties';

    protected $fillable = [
        'description', 'address', 'number', , 'district_id', 'base_price', 'covered_area',
        'build_area', 'total_area', 'rooms', 'bathrooms', 'year_build', 'created_by', 'updated_by'
    ];

    public $timestamps = true;

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'property_features');
    }
}

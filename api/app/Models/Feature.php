<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $table = 'features';

    protected $fillable = ['feature_name', 'created_by', 'updated_by'];

    public $timestamps = true;

    public function properties()
    {
        return $this->belongsToMany(Property::class, 'property_features');
    }
}

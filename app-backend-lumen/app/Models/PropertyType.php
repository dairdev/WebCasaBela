<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    protected $table = 'property_types';

    protected $fillable = ['feature_id', 'property_id', 'created_by', 'updated_by'];

    public $timestamps = true;
}

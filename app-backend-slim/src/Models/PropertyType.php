<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    protected $table = 'property_types';
    
    protected $fillable = [
        'description'
    ];
    
    public $timestamps = false; // Esta tabla no tiene created_at/updated_at
    
    public function properties()
    {
        return $this->hasMany(Property::class, 'propertytype_id');
    }
}

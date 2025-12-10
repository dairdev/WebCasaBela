<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Property extends Model
{
    protected $table = 'properties';
    
    protected $fillable = [
        'propertytype_id',
        'description',
        'district_id',
        'address',
        'number',
        'floor',
        'department_number',
        'building_name',
        'floors',
        'base_price',
        'shown_price',
        'contract_price',
        'covered_area',
        'build_area',
        'total_area',
        'to_rent',
        'to_sell',
        'rooms',
        'bathrooms',
        'garages',
        'laundries',
        'water_tanker',
        'yards',
        'year_build',
        'is_active',
        'created_by',
        'updated_by'
    ];
    
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    
    protected $casts = [
        'to_rent' => 'boolean',
        'to_sell' => 'boolean',
        'is_active' => 'boolean',
        'base_price' => 'double',
        'shown_price' => 'double',
        'contract_price' => 'double',
        'covered_area' => 'double',
        'build_area' => 'double',
        'total_area' => 'double',
        'floor' => 'integer',
        'department_number' => 'integer',
        'floors' => 'integer',
        'rooms' => 'integer',
        'bathrooms' => 'integer',
        'garages' => 'integer',
        'laundries' => 'integer',
        'water_tanker' => 'integer',
        'yards' => 'integer',
        'year_build' => 'integer'
    ];
    
    public function propertyType(): BelongsTo
    {
        return $this->belongsTo(PropertyType::class, 'propertytype_id');
    }
    
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }
    
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    
    // Scopes para filtros comunes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeForRent($query)
    {
        return $query->where('to_rent', true);
    }
    
    public function scopeForSale($query)
    {
        return $query->where('to_sell', true);
    }
    
    public function scopeByDistrict($query, $districtId)
    {
        return $query->where('district_id', $districtId);
    }
    
    public function scopeByPropertyType($query, $propertyTypeId)
    {
        return $query->where('propertytype_id', $propertyTypeId);
    }
    
    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        return $query->whereBetween('shown_price', [$minPrice, $maxPrice]);
    }
}

<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';
    
    protected $fillable = [
        'name',
        'province_id',
        'created_by',
        'updated_by'
    ];
    
    protected $dates = [
        'created_at',
        'updated_at'
    ];
    
    public function province()
    {
        return $this->belongsTo(Province::class);
    }
    
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}

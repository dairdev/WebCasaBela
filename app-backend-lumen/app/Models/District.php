<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    protected $table = 'districts';

    protected $fillable = ['name', 'province_id', 'created_by', 'updated_by'];

    public $timestamps = true;

    public function province()
    {
        return $this->belongsTo(Province::class);
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}

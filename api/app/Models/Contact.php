<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'address', 'phone', 'property_id', 'created_by', 'updated_by'
    ];

    public $timestamps = true;

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}

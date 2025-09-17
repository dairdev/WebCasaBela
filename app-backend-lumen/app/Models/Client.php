<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = [
        'first_name', 'last_name', 'email', 'phone', 'preferred_contact_method', 
        'preferences', 'created_by', 'updated_by'
    ];

    public $timestamps = true;

    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
}

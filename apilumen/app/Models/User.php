<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = ['email', 'password', 'last_connection', 'role_id', 'created_by', 'updated_by'];

    public $timestamps = true;

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}

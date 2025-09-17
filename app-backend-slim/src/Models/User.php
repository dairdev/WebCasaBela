<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = "users";

    protected $fillable = [
        "email",
        "password",
        "last_connection",
        "role_id",
        "created_by",
        "updated_by",
    ];

    protected $hidden = ["password"];

    protected $dates = ["last_connection", "created_at", "updated_at"];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, "created_by");
    }

    public function updater()
    {
        return $this->belongsTo(User::class, "updated_by");
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes["password"] = password_hash(
            $password,
            PASSWORD_DEFAULT
        );
    }

    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }
}

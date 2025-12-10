<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, "created_by");
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, "updated_by");
    }

    public function setPasswordAttribute(string $password): void
    {
        $this->attributes["password"] = password_hash(
            $password,
            PASSWORD_DEFAULT
        );
    }

    public function verifyPassword(string $password): bool
    {
        return password_verify($password, $this->password);
    }
}

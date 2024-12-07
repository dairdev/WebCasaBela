<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $fillable = ['name', 'created_by', 'updated_by'];

    public $timestamps = true;

    public function provinces()
    {
        return $this->hasMany(Province::class);
    }
}

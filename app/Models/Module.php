<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'system_id'
    ];

    /**
     * Get the roles allowed to see the module.
     */
    public function roles()
    {
        return $this->hasMany(ModuleAllowRole::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use HasFactory;

    /**
     * Get the modules for the system.
     */
    public function modules()
    {
        return $this->hasMany(Module::class);
    }
}

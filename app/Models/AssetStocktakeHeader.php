<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetStocktakeHeader extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team', 'name', 'ext',
        'location', 'status'
    ];

    /**
     * Get the line associated with the header.
     */
    public function line()
    {
        return $this->hasOne(AssetStocktakeLine::class);
    }
}

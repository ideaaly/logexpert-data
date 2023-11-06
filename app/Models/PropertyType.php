<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyType extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'price_senior',
        'price_beginner',
        'sale_price'
    ];

    /**
     * Get properties related to the property type.
     */
    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}

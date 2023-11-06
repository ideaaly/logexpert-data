<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'owner_name',
        'address1',
        'address2',
        'building_number',
        'appt_number',
        'zip_code',
        'city',
        'country',
        'year_construction',
        'surface',
        'water',
        'heating',
        'is_furnished',
        'has_parking',
        'parking_number',
        'has_cellar',
        'cellar_number',
        'property_type_id',
        'notes'
    ];

    /**
     * Get inventories related to the property.
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
    /**
     * Get the property Type related to the property.
     */
    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }
}

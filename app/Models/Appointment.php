<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'g_event_id'
    ];


    /**
     * Get the appointment associated with the inventory.
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
        // return $this->hasMany(Inventory::class);
    }
}

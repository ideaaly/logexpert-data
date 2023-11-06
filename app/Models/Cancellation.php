<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cancellation extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reason',
        'user_id',
        'inventory_id'
    ];


    /**
     * Get the inventory associated with the cancellation.
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
    /**
     * Get the user associated with the inventory.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'inventory_id',

        'total_price',
        'expense_expert',
        'expense_travel',
        'cost_expert'
    ];

    /**
     * Get the appointment associated with the inventory.
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}

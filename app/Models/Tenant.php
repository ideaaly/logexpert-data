<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_name',
        'name',
        'gender',
        'email',
        'phone',
        'notes'
    ];

    /**
     * Get inventories for the tenant.
     */
    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}

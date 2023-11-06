<?php

namespace App\Models;

use App\Models\Cancellation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status',
        'type',
        'reference',
        'lease_end_at',
        'lease_begins_at',
        'date_wanted',
        'period_wanted',
        'user_id',
        'tenant_id',
        'property_id',
        'appointment_id',
        'property_type',
        'user_referent_id',
        'key_notes',
        'agency'
    ];




    /**
     * Get the user associated with the inventory.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the tenant associated with the inventory.
     */
    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    /**
     * Get the property associated with the inventory.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    /**
     * Get the appointment associated with the inventory.
     */
    public function appointment()
    {
        return $this->belongsTo(Appointment::class);
    }

    /**
     * Get Inventory details
     *
     * @return array
     */
    public function getDetails(Inventory $inventory)
    {
        $property = $inventory->property->toArray();
        $propertyType = $inventory->property->propertyType;
        $tenant = $inventory->tenant->toArray();
        $user_referent = User::find($inventory['user_referent_id']);
        $inventoryArray = $inventory->toArray();
        $appointment_date = array();
        if ($inventory->appointment) {
            $appointment = $inventory->appointment;
            $appointment_date = $appointment->date;
        } else {
            $appointment = array();
        }
        $inventoryDetails = array_merge(
            $inventoryArray,
            array('tenant' => $tenant),
            array('property' => $property),
            array('propertyType' => $propertyType),
            array('user_referent' => $user_referent),
            array('appointment' => $appointment),
            array('appointment_date' => $appointment_date)
        );
        return $inventoryDetails;
    }

    /**
     * Get Inventories with Ordered Status (1)
     * @return array
     */
    public function filterByStatus($status)
    {
        $inventories = Inventory::Where('status', $status)->get();
        //dd($inventories);
        $inventoriesWithDetails = array();
        foreach ($inventories as $inventory) {
            $inventoriesWithDetails[] = $inventory->getDetails($inventory);
        }

        return $inventoriesWithDetails;
        
    }
    public function order()
    {
        return $this->hasOne(Order::class);
    }

    public function cancellation()
    {
        return $this->hasMany(Cancellation::class);
    }
}


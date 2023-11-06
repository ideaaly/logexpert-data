<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Inventory;
use App\Models\Tenant;
use App\Models\Order;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon;

class DasboardController extends Controller
{
    public function displayManager()
    {
        $inventories = Inventory::all();
        $data = array();
        foreach ($inventories as $inventory) {
            $data[] = $inventory->getDetails($inventory);
        }


        $inventoriesByStatus = new Inventory();
        $inventoriesByStatus = Inventory::all()->groupBy('status');

        return Inertia::render('DashboardManager', ['data' => $data, 'inventoriesByStatus' => $inventoriesByStatus]);
    }
    public function displayExpert()
    {
        $status = [3, 4, 5, 99];
        $inventories = Inventory::all()->where('status', $status);
        $data = array();
        foreach ($inventories as $inventory) {
            $data[] = $inventory->getDetails($inventory);
        }

        $userref_id = Auth::user()->id;
        $inventoriesByStatus = new Inventory();
        $inventoriesByStatus = Inventory::all()->where(
            'user_referent_id',
            '=',
            $userref_id
        )->whereIn('status', $status)->groupBy('status');

        return Inertia::render('DashboardExpert', ['data' => $data, 'inventoriesByStatus' => $inventoriesByStatus]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Inventory;
use App\Models\Tenant;
use App\Models\Order;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\Appointment;
use App\Models\User;
use App\Models\Cancellation;
use Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\GoogleCalendar\Event;

use Illuminate\Support\Facades\Mail;
use App\Mail\InventoryCancelled;

class ExpertController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listAssigned()
    {
        $data = new Inventory();
        $userref_id = Auth::user()->id;

        $inventories = Inventory::all()->where(
            'user_referent_id',
            '=',
            $userref_id
        )->where('status', '=', 3);

        $inventoriesWithDetails = array();
        foreach ($inventories as $inventory) {
            $inventoriesWithDetails[] = $inventory->getDetails($inventory);
        }
        $data = $inventoriesWithDetails;

        return Inertia::render('Experts/ListAssigned', ['data' => $data]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listTodo()
    {
        $data = new Inventory();
        $userref_id = Auth::user()->id;

        $inventories = Inventory::all()->where(
            'user_referent_id',
            '=',
            $userref_id
        )->where('status', '=', 4);

        $inventoriesWithDetails = array();
        foreach ($inventories as $inventory) {
            $inventoriesWithDetails[] = $inventory->getDetails($inventory);
        }
        $data = $inventoriesWithDetails;

        return Inertia::render('Experts/ListTodo', ['data' => $data]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listFinished()
    {
        $data = new Inventory();
        $userref_id = Auth::user()->id;

        $inventories = Inventory::all()->where(
            'user_referent_id',
            '=',
            $userref_id
        )->where('status', '=', 5);

        $inventoriesWithDetails = array();
        foreach ($inventories as $inventory) {
            $inventoriesWithDetails[] = $inventory->getDetails($inventory);
        }
        $data = $inventoriesWithDetails;

        return Inertia::render('Experts/ListFinished', ['data' => $data]);
    }
}

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

class CancellationController extends Controller
{
    public function index()
    {
        $data = array();
        $cancellations = Cancellation::all()->sortByDesc('created_at');

        foreach ($cancellations as $cancellation) {
            $cancelArray = $cancellation->toArray();
            $user = User::find($cancellation->user_id)->toArray();
            $inventory = Inventory::find($cancellation->inventory_id)->toArray();
            $data[] = array_merge(
                $cancelArray,
                array('user' => $user),
                array('inventory' => $inventory)
            );
        }

        return Inertia::render('Cancellations/List', [
            'data' => $data,
        ]);
    }
}

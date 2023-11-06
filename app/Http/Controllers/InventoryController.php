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
use Illuminate\Support\Facades\DB;
use App\Mail\InventoryCancelled;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::whereNotIn('status', [100])->latest()->get();
        $data = array();
        
        //Function of pagination for 10.
        //$inventories = Inventory::whereNotIn('status', [100])->latest()->paginate(10);
        //$inventories = Inventory::all();

        //$inventories = Inventory::with('tenant', 'property.property_type', 'appointment',)->get();

        //$inventories->load('tenant', 'property.property_type', 'appointment');
        

        // Experts List for datatable
        $allExperts = array();
        foreach ($inventories as $inventory) {
            $data[] = $inventory->getDetails($inventory);

            if (($inventory['user_referent_id'])) {
                $name = User::find($inventory['user_referent_id'])->name;
                $allExperts[] = $name;
            }
        }
        
        $experts = array_unique($allExperts, SORT_REGULAR);
        $experts_iterable = array();
        $expertNames_iterable = array();
        foreach ($experts as $expert) {
            $experts_iterable[] = $expert;
        }
        foreach ($experts as $expert) {
            $expertNames_iterable[]['name'] = $expert;
        }
        
        // Return view
        
        return Inertia::render('Inventories/List', ['data' => $data, 'experts' => $experts_iterable, 'expertNames' => $expertNames_iterable]);
    }

    public function test() {
        //$data = Inventory::all();
        $data = Inventory::with('tenant','property', 'appointment')->paginate(25);
        return Inertia::render('Inventories/Test', ['data' => $data]);



            
                    
        
          
        // Pagination avec 10 par page    
        // tests de chargement de collection
        //return view('Inventories.test', compact('inventories'));
        //return view('Inventories.test', ['inventories' => DB::table('inventories')->paginate(10)
        
        




        // return view('Inventories.test', ['inventories' => DB::table('inventories')->paginate(10)
        // ]);
        //return view('Inventories.test', compact('inventories', 'experts'));
    }

    /**
     * Display a listing of drafts inventories.
     *
     * @return \Illuminate\Http\Response
     */
    public function listDrafts()
    {
        $data = new Inventory();
        $data = $data->filterByStatus(0);

        return Inertia::render('Inventories/ListDrafts', ['data' => $data]);
    }
    /**
     * Display a listing of ordered inventories.
     *
     * @return \Illuminate\Http\Response
     */
    public function listOrdered()
    {
        $data = new Inventory();
        $data = $data->filterByStatus(1);

        return Inertia::render('Inventories/ListOrdered', ['data' => $data]);
    }

    /**
     * Display a listing of confirmed inventories.
     *
     * @return \Illuminate\Http\Response
     */
    public function listConfirmed()
    {
        $data = new Inventory();
        
        $data = $data->filterByStatus(2);
        // dd($data);

        return Inertia::render('Inventories/ListConfirmed', ['data' => $data]);
    }

    /**
     * Display a listing of assigned inventories.
     *
     * @return \Illuminate\Http\Response
     */
    public function listAssigned()
    {
        $data = new Inventory();
        $data = $data->filterByStatus(3);
        return Inertia::render('Inventories/ListAssigned', ['data' => $data]);
    }

    /**
     * Display a listing of inventories to do.
     *
     * @return \Illuminate\Http\Response
     */
    public function listTodo()
    {
        $data = new Inventory();
        $data = $data->filterByStatus(4);

        return Inertia::render('Inventories/ListTodo', ['data' => $data]);
    }

    /**
     * Display a listing of finished inventories.
     *
     * @return \Illuminate\Http\Response
     */
    public function listFinished()
    {
        $data = new Inventory();
        $data = $data->filterByStatus(5);

        return Inertia::render('Inventories/ListFinished', ['data' => $data]);
    }

    /**
     * Display a listing of cancelled inventories.
     *
     * @return \Illuminate\Http\Response
     */
    public function listCancelled()
    {
        $data = new Inventory();
        $data = $data->filterByStatus(99);

        return Inertia::render('Inventories/ListCancelled', ['data' => $data]);
    }


    /**
     * Display a listing of archived inventories.
     *
     * @return \Illuminate\Http\Response
     */
    public function listArchived()
    {
        $data = new Inventory();
        $data = $data->filterByStatus(100);

        return Inertia::render('Inventories/ListArchived', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function archiveInventory($id)
    {

        // Return view
        return Inertia::render('Inventories/ArchiveForm', [
            'inventory_id' => $id,
            'inventory' => Inventory::find($id),
            'property' => Inventory::find($id)->property,
            'tenant' => Inventory::find($id)->tenant,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateInventorytoArchived(Request $request)
    {
        // Retrieve the validated input data...
        $id = $request['inventory_id'];
        $inventory = Inventory::find($id);

        // Update inventory
        $inventory->update([
            'appointment_id' => 0,
            'status' => 100
        ]);


        return redirect()->route('inventories.index')
            ->with('message', 'État des lieux Archivé.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function confirmInventory($id)
    {
        $inventory = Inventory::find($id);
        $inventoryDetails = $inventory->getDetails($inventory);
        $propertyDetails = $inventory->property;
        $tenantDetails = $inventory->tenant;

        $appointmentDetails = $inventory->appointment;

        return Inertia::render('Inventories/ConfirmForm', [
            'inventory_id' => $inventory->id,
            'inventory' => $inventoryDetails,
            'property' => $propertyDetails,
            'tenant' => $tenantDetails,
            'appointment' => $appointmentDetails
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateInventorytoConfirm(Request $request)
    {
        // Retrieve the validated input data...
        $id = $request['inventory_id'];

        $expense_travel = floatval($request['expense_travel']);
        
        $expense_expert = floatval(Inventory::find($id)->property->propertyType['sale_price']);
        $total_price = $expense_travel + $expense_expert;
        $cost_expert = floatval(Inventory::find($id)->property->propertyType['price_senior']);
        $lease_end_at = "1900-01-01 00:00:00";
        $lease_begins_at = "1900-01-01 00:00:00";

        Order::create(
            [
                'status' => $request->input('status'),
                'type' => $request->input('type'),
                'inventory_id' => $request->input('inventory_id'),
                'reference' => $request->input('reference'),
                'lease_end_at' => $lease_end_at,
                'lease_begins_at' => $lease_begins_at,
                'total_price' => $total_price,
                'expense_expert' => $expense_expert,
                'expense_travel' => $expense_travel,
                'cost_expert' => $cost_expert
            ]
        );

        Inventory::find($id)->update($request->all());


        return redirect()->route('list.ordered.inventories')
            ->with('message', 'État des lieux confirmé');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function cancelInventory($id)
    {

        // Return view
        return Inertia::render('Inventories/CancelForm', [
            'inventory_id' => $id,
            'inventory' => Inventory::find($id),
            'property' => Inventory::find($id)->property,
            'tenant' => Inventory::find($id)->tenant,
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateInventorytoCancelled(Request $request)
    {
        // Retrieve the validated input data...
        $id = $request['inventory_id'];
        $inventory = Inventory::find($id);
        $userref_id = Auth::user()->id;

        if ($inventory->appointment) {
            // Delete on Google Calendar
            // Config calendar
            $id_calendar = Auth::user()->g_calid;
            config(['google-calendar.calendar_id' => $id_calendar]);

            $g_event_id = $inventory->appointment->g_event_id;
            $event = Event::find($g_event_id);
            $event->delete();

            // Update inventory
            $inventory->update([
                'appointment_id' => 0,
                'status' => 99
            ]);
        } else {
            // Update inventory
            $inventory->update([
                'appointment_id' => 0,
                'status' => 99
            ]);
        }

        $cancellation_id = Cancellation::create(
            [
                'reason' => $request->input('reason'),
                'inventory_id' => $request->input('inventory_id'),
                'user_id' => $userref_id,
            ]
        )->id;

        $cancellation = Cancellation::find($cancellation_id);
        $userHasCancelled = Auth::user();

        // Send e-mail
        // Mail::mailer('postmark')->to('commandes@logexpert33.com')->send(new InventoryCancelled($inventory, $cancellation, $userHasCancelled));
        // Mail::mailer('postmark')->to('lmigliore@nexity.fr')->send(new InventoryCancelled($inventory, $cancellation, $userHasCancelled));

        return redirect()->route('dashboard')
            ->with('message', 'État des lieux annulé. Une notification a été envoyé à l\'administrateur');
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateToFinished()
    {
        $inventoriesToUpdate = array();

        // $inventories = Inventory::where('status', 4)->update(['status' => 5]);
        $inventories = Inventory::where('status', 4)->get();

        $today = Carbon\Carbon::today();
        foreach ($inventories as $inventory) {
            $appointment = $inventory->appointment->date;
            $inventoriesToUpdate[] = $appointment;

            if ($appointment < $today) {
                $inventory->update(['status' => 5]);
            }

            // if (($inventory->appointment->date)) {
            //     $name = User::find($inventory['user_referent_id'])->name;
            //     $allExperts[] = $name;
            // }
        }

        // dd($today);


        print_r('OK');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Inventories/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'status' => 'required',
            'type' => 'required',
            'agency' => 'required',
            'reference' => 'required',
        ]);

        // Create associated Tenant
        $tenant_id = Tenant::create()->id;

        // Create associated Property
        $property_id = Property::create()->id;

        // Create associated Appointment
        // $appointment_id = Appointment::create()->id;

        if ($request->input('lease_end_at') == null) {
            $lease_end_at = "";
        } else {
            $lease_end_at = $request->input('lease_end_at');
        }
        if ($request->input('lease_begins_at') == null) {
            $lease_begins_at = "";
        } else {
            $lease_begins_at = $request->input('lease_begins_at');
        }
        if ($request->input('date_wanted') == null) {
            $date_wanted = "";
        } else {
            $date_wanted = $request->input('date_wanted');
        }
        $now = Carbon\Carbon::now();
        $inventory_id = Inventory::create(
            [
                'status' => $request->input('status'),
                'type' => $request->input('type'),
                'agency' => $request->input('agency'),
                'reference' => $request->input('reference'),
                'lease_end_at' => $lease_end_at,
                'lease_begins_at' => $lease_begins_at,
                'date_wanted' => $date_wanted,
                'tenant_id' => $tenant_id,
                'property_id' => $property_id,
                // 'appointment_id' => $appointment_id
            ]
        )->id;

        return redirect()->route('edit.property', ['id' => $inventory_id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        $inventoryDetails = $inventory->getDetails($inventory);
        $propertyDetails = $inventory->property->with('property_type');
        $tenantDetails = $inventory->tenant;

        $appointmentDetails = $inventory->appointment;
        //$appointmentDetails::where('g_event_id', $appointmentDetails->g_event_id)->get();
        

        return Inertia::render('Inventories/Single', [
            'inventory' => $inventoryDetails,
            'property' => $propertyDetails,
            'tenant' => $tenantDetails,
            // 'appointment' => $appointmentDetails

        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function showTodo(Inventory $inventory)
    {
        $inventoryDetails = $inventory->getDetails($inventory);
        $propertyDetails = $inventory->property;
        $tenantDetails = $inventory->tenant;
        return Inertia::render('Inventories/SingleTodo', [
            'inventory' => $inventoryDetails,
            'property' => $propertyDetails,
            'tenant' => $tenantDetails
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInventoryRequest  $request
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        // Retrieve the validated input data...
        $id = $request['id'];

        if (!empty($id)) {
            Inventory::find($id)->update($request->all());
            return redirect()->back()
                ->with('message', 'Inventory Updated Successfully.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        $inventory->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory deleted successfully');
    }
}

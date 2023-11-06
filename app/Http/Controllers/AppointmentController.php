<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Inventory;
use App\Models\Tenant;
use App\Models\Property;
use Spatie\GoogleCalendar\Event;
use Carbon;
use Config;
use App\Models\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\AppointmentNewAdmin;
use App\Mail\AppointmentNewManager;
use App\Mail\AppointmentNewTenant;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::all()->where('status', 1);
        $data = Inventory::all();
        return Inertia::render('Appointments/List', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return Inertia::render('Appointments/Create');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createInventoryAppointment($id)
    {

        $inventory = Inventory::find($id);
        $inventoryDetails = $inventory->getDetails($inventory);
        $propertyDetails = $inventory->property;
        $tenantDetails = $inventory->tenant;

        $appointmentDetails = $inventory->appointment;

        return Inertia::render('Appointments/Create', [
            'inventory' => $inventoryDetails,
            'property' => $propertyDetails,
            'tenant' => $tenantDetails,
            'appointment' => $appointmentDetails
        ]);
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
        $request->validate([]);

        // Prepare Inventory
        $inventory = Inventory::find($request->input('inventory_id'));
        $inventoryDetails = $inventory->getDetails($inventory);

        // Prepare Appointment
        // $appointment = $inventory->appointment;

        // Create Event
        $event = new Event;
        $startDate =
            \Carbon\Carbon::parse($request->input('date'));


        if ($inventoryDetails['type'] == 1) {
            $inventory_type = "ELe";
        } elseif ($inventoryDetails['type'] == 2) {
            $inventory_type = "ELs";
        } else {
            $inventory_type = "";
        };

        $permalink = route("show.todo.single", $request->input('inventory_id'));
        $reference = strtoupper($inventoryDetails['reference']);
        $event->name =
            $inventory_type . ' - ' .
            $inventoryDetails['propertyType']['name'] . ' - ' .
            $reference . ' - ' .
            $inventoryDetails['property']['city'];
        $event->description =
            $inventoryDetails['property']['address1'] . '<br>' .
            $inventoryDetails['property']['address2'] . '<br>' .
            $inventoryDetails['property']['zip_code'] . ' - ' .
            $inventoryDetails['property']['city'] . '<br>'
            . '<br><strong>Récupération / Dépôt clés : ' . $inventoryDetails['key_notes'] . '</strong><br><br>' .
            $permalink . '<br><br>Note : ' .
            $inventoryDetails['tenant']['notes'];

        // Lien
        $event->startDateTime = $startDate;
        $event->endDateTime = $startDate->addHour();

        // Config calendar
        $id_calendar = Auth::user()->g_calid;
        config(['google-calendar.calendar_id' => $id_calendar]);

        // Store event on Google
        $newEvent = $event->save();

        // Output Google Calendar ID
        $g_event_id = $newEvent->id;

        // Update Appointment on Logexpert
        $timeZone = Config::get('app.timezone');
        $startDateTz =
            \Carbon\Carbon::parse($request->input('date'))->tz($timeZone);
        $appointment_id = Appointment::create(
            [
                'date' => $startDateTz,
                'g_event_id' => $g_event_id
            ]
        )->id;


        // Update Inventory Status
        $inventory->update(
            [
                'appointment_id' => $appointment_id,
                'status' => $request->input('status'),
            ]

        );
        if ($inventoryDetails['tenant']['email'] != '') {
            $tenantEmail = $inventoryDetails['tenant']['email'];
        } else $tenantEmail = 'commandes@logexpert33.com';


        $user_referent_id = $inventory->user_referent_id;
        // Send e-mail
        // Mail::mailer('postmark')->to('commandes@logexpert33.com')->send(new AppointmentNewAdmin($inventory, $appointment_id, $user_referent_id));
        // Mail::mailer('postmark')->to('lmigliore@nexity.fr')->send(new AppointmentNewManager($inventory, $appointment_id, $user_referent_id));


        try {
            // Mail::mailer('postmark')->to($tenantEmail)->send(new AppointmentNewTenant($inventory, $appointment_id, $user_referent_id));
        } catch (\Exception $ignored) {
            //Ignored
        }

        return redirect()->route('list.expert.assigned')->with('message', 'Le rendez vous a bien été créé, des notifications ont été envoyées.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {

        // $inventoryDetails = $inventory->getDetails($inventory);

        // return Inertia::render('Inventories/Single', [
        //     'inventory' => $inventoryDetails,
        // ]);

        $inventoryDetails = $inventory->getDetails($inventory);
        $propertyDetails = $inventory->property;
        $tenantDetails = $inventory->tenant;
        return Inertia::render('Appointments/Single', [
            'inventory' => $inventoryDetails,
            'property' => $propertyDetails,
            'tenant' => $tenantDetails
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function editInventoryAppointment($id)
    {

        $inventory = Inventory::find($id);
        $inventoryDetails = $inventory->getDetails($inventory);
        $propertyDetails = Inventory::find($id)->property;
        $tenantDetails = Inventory::find($id)->tenant;

        // Test email
        // $appointment_id = 2;
        // $user_referent_id = 1;
        // try {
        //     Mail::mailer('postmark')->to('herjzenfijzneicjnzeicuny.rasolon@gmail.com')->send(new AppointmentNewManager($inventory, $appointment_id, $user_referent_id));
        // } catch (\Exception $ignored) {
        //     //Ignored
        // }
        // End test

        return Inertia::render('Appointments/Edit', [
            'inventory_id' => $id,
            'inventory' => $inventoryDetails,
            'property' => $propertyDetails,
            'tenant' => $tenantDetails
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function updateInventoryAppointment(Request $request)
    {
        // Set the right Calendar
        // Config calendar
        $id_calendar = Auth::user()->g_calid;
        config(['google-calendar.calendar_id' => $id_calendar]);

        // Retrieve the validated input data...
        $appointmentId = $request['appt_id'];
        $inventoryId = $request['inventory_id'];
        $inventory = Inventory::find($request->input('inventory_id'));

        $timeZone = Config::get('app.timezone');

        $newDateTime = \Carbon\Carbon::parse($request['date'])->tz($timeZone);
        $g_event_id = $request['g_event_id'];

        // Get the Event
        $event = Event::find($g_event_id);

        // Update existing google event
        $event->startDateTime = $newDateTime;
        $event->startTimeZone = $timeZone;
        $event->endDateTime = $newDateTime->addHour();
        $event->endTimeZone = $timeZone;
        $event->save();
        // print_r($event->startDateTime);
        // print_r($newDateTime);
        // Update existing appointment
        Appointment::find($appointmentId)->update(
            [
                'date' => $newDateTime->subHour(),
            ]
        );

        $inventoryDetails = $inventory->getDetails($inventory);

        if ($inventoryDetails['tenant']['email'] != '') {
            $tenantEmail = $inventoryDetails['tenant']['email'];
        } else $tenantEmail = 'commandes@logexpert33.com';


        $user_referent_id = $inventory->user_referent_id;
        // Send e-mail
        // Mail::mailer('postmark')->to('commandes@logexpert33.com')->send(new AppointmentNewAdmin($inventory, $appointmentId, $user_referent_id));

        // try {
        //     Mail::mailer('postmark')->to($tenantEmail)->send(new AppointmentNewTenant($inventory, $appointmentId, $user_referent_id));
        // } catch (\Exception $ignored) {
        //     //Ignored
        // }

        // try {
        //     Mail::mailer('postmark')->to('lmigliore@nexity.fr')->send(new AppointmentNewManager($inventory, $appointmentId, $user_referent_id));
        // } catch (\Exception $ignored) {
        //     //Ignored
        // }

        return redirect()->route('list.expert.todo')
            ->with('message', 'EDL mis à jour. Des notifications ont été envoyées');
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
                ->with('message', 'Appointment Updated Successfully.');
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

        return redirect()->route('appointments.index')
            ->with('success', 'Appointment  deleted successfully');
    }
}

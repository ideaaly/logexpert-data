<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Inventory;
use App\Models\User;
use App\Models\Tenant;
use App\Models\Property;

use Illuminate\Support\Facades\Mail;
use App\Mail\ExpertAssigned;

class InventoryUserController extends Controller
{

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $inventories = Inventory::all()->where('status', 2);
        $data = array();
        foreach ($inventories as $inventory) {
            if ($inventory['user_referent_id'] == 0) {
                $data[] = $inventory->getDetails($inventory);
            }
        }

        return Inertia::render('Inventories/AssignList', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function assignUserReferent($id)
    {

        $expertsList = User::all();
        $experts = array();
        // print_r('<pre>');
        // print_r($expertsList);
        // print_r('</pre>');
        foreach ($expertsList as $expert) {
            // Access a user's currently selected team...
            $team = $expert->currentTeam;

            if ($expert->teamRole($team)) {
                if (
                    $expert->teamRole($team)->key != "manager" ||
                    $expert->teamRole($team)->key != "consultant"
                ) {
                    $experts[] = $expert;
                }
            }
        }
        $inventory = Inventory::find($id);

        $inventoryDetails = $inventory->getDetails($inventory);
        $propertyDetails = Inventory::find($id)->property;
        $tenantDetails = Inventory::find($id)->tenant;
        return Inertia::render('Inventories/AssignUserForm', [
            'inventory_id' => $id,
            'inventory' => $inventoryDetails,
            'property' => $propertyDetails,
            'experts' => $experts,
            'tenant' => $tenantDetails,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUserReferent(Request $request)
    {

        // print_r('OK');
        $this->validate($request, [
            // 'user_referent_id' => 'required',
        ]);

        // Retrieve the validated input data...
        $id = $request['inventory_id'];
        // dump($request);
        if (!empty($id)) {
            Inventory::find($id)->update($request->all());

            $inventory = Inventory::find($id);
            $userRef = User::find($request['user_referent_id']);
            $userRefEmail = $userRef->email;
            // Mail::mailer('postmark')->to($userRefEmail)->send(new ExpertAssigned($inventory, $userRef));

            return redirect()->route('list.confirmed.inventories')
                ->with('message', 'Expert bien affecté à l\'EDL');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    // public function updateUserReferent()
    // {
    //     return redirect()->route('assign.list');
    // }
}

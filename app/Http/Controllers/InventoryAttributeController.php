<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Inventory;
use App\Models\Tenant;
use App\Models\Property;
use App\Models\PropertyType;
use App\Models\User;

use Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderNew;
use App\Mail\OrderNewEntryManager;
use App\Mail\OrderNewEntryTenant;

class InventoryAttributeController extends Controller
{

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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function editInventory($id)
    {

        $inventory = Inventory::find($id);
        $inventoryDetails = $inventory->getDetails($inventory);
        $propertyDetails = Inventory::find($id)->property;
        $tenantDetails = Inventory::find($id)->tenant;
        return Inertia::render('InventoryAttributes/EditInventory', [
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
    public function updateInventory(Request $request)
    {
        // Retrieve the validated input data...
        $id = $request['inventory_id'];
        // print_r($id);
        // dump($request);
        // dump(Inventory::find($id)->property->id);
        if (!empty($id)) {
            Inventory::find($id)->update($request->all());
            return redirect()->route('edit.property', ['id' => $id])
                ->with('message', 'EDL mis à jour.');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function editProperty($id)
    {

        $inventory = Inventory::find($id);
        $inventoryDetails = $inventory->getDetails($inventory);
        $propertyDetails = Inventory::find($id)->property;
        $tenantDetails = Inventory::find($id)->tenant;
        $propertyType = Inventory::find($id)->property_type;
        $propertyTypes = PropertyType::all();
        return Inertia::render('InventoryAttributes/EditProperty', [
            'inventory_id' => $id,
            'inventory' => $inventoryDetails,
            'property' => $propertyDetails,
            'tenant' => $tenantDetails,
            'property_types' => $propertyTypes
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function updateProperty(Request $request)
    {

        $this->validate($request, [
            'property_type_id' => 'required|not_in:0',
        ]);
        // Retrieve the validated input data...
        $id = $request['inventory_id'];
        // print_r($id);
        // dump($request);
        // dump(Inventory::find($id)->property->id);
        if (!empty($id)) {
            Inventory::find($id)->property->update($request->all());
            return redirect()->route('edit.tenant', ['id' => $id])
                ->with('message', 'Logement de l\'EDL mis à jour');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function editTenant($id)
    {

        $inventory = Inventory::find($id);
        $inventoryDetails = $inventory->getDetails($inventory);
        $propertyDetails = Inventory::find($id)->property;
        $tenantDetails = Inventory::find($id)->tenant;
        return Inertia::render('InventoryAttributes/EditTenant', [
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
    public function updateTenant(Request $request)
    {
        // Retrieve the validated input data...
        $id = $request['inventory_id'];
        // print_r($id);
        // dump($request);
        // dump(Inventory::find($id)->tenant->id);
        if (!empty($id)) {
            Inventory::find($id)->tenant->update($request->all());
            return redirect()->route('edit.informations', ['id' => $id])
                ->with('message', 'Locataire de l\'EDL mis à jour');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function editInformations($id)
    {

        $inventory = Inventory::find($id);
        $inventoryDetails = $inventory->getDetails($inventory);
        $propertyDetails = Inventory::find($id)->property;
        $tenantDetails = Inventory::find($id)->tenant;
        // $now = Carbon\Carbon::now();
        // dd($now);
        return Inertia::render('InventoryAttributes/EditInformations', [
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
    public function updateInformations(Request $request)
    {
        // Retrieve the validated input data...
        $id = $request['inventory_id'];

        // Publish
        $data['status'] = 1;
        $request->merge($data);
        $inventory = Inventory::find($id);
        $inventoryDetails = $inventory->getDetails($inventory);

        if ($inventoryDetails['tenant']['email'] != '') {
            $tenantEmail = $inventoryDetails['tenant']['email'];
        } else $tenantEmail = 'commandes@logexpert33.com';

        if (!empty($id)) {
            Inventory::find($id)->update($request->all());

            // Send email
            // Mail::mailer('postmark')->to('commandes@logexpert33.com')->send(new OrderNew($inventory, $request['date_wanted']));

            // Si EDL Entrée 
            // if ($inventory->type == 1) {
            //     try {
            //         Mail::mailer('postmark')->to($tenantEmail)->send(new OrderNewEntryTenant($inventory));
            //     } catch (\Exception $ignored) {
            //         //Ignored
            //     }
            //     Mail::mailer('postmark')->to('cbelloc@nexity.fr')->send(new OrderNewEntryManager($inventory));
            // }

            return redirect()->route('inventories.index')
                ->with('message', 'Votre EDL a bien été commandé, vous allez recevoir un e-mail de confirmation.');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function updateInformationsDraft(Request $request)
    {
        // Retrieve the validated input data...
        $id = $request['inventory_id'];
        // print_r($id);
        // dump($request);
        // dump(Inventory::find($id)->tenant->id);

        // Draft
        $data['status'] = 0;
        $request->merge($data);

        if (!empty($id)) {
            Inventory::find($id)->update($request->all());
            return redirect()->route('inventories.index')
                ->with('message', 'EDL créé & enregistré en brouillon.');
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Models\Property  $property
     * @return \Illuminate\Http\Response
     */
    public function updateAfterConfirmed(Request $request)
    {
        // Retrieve the validated input data...
        $id = $request['inventory_id'];


        if (!empty($id)) {
            Inventory::find($id)->update($request->all());
            return redirect()->route('inventories.index')
                ->with('message', 'EDL créé & enregistré en brouillon.');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\PropertyType;
use App\Models\Inventory;
use App\Models\Tenant;
use App\Models\Property;
use App\Models\User;
use Carbon;

class PropertyTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $propery_types = PropertyType::all();

        return Inertia::render('PropertyType/List', ['data' => $propery_types]);
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
            'name' => 'required',
            'price_senior' => 'required',
            'price_beginner' => 'required',
            'sale_price' => 'required',
        ]);

        $propery_type = PropertyType::create(
            $request->all()
        )->id;


        return redirect()->route('list.property_types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  $id
     */
    public function destroy($id)
    {
        $property_type = PropertyType::find($id);
        $property_type->delete();
        // print_r($id);

        return redirect()->route('list.property_types')
            ->with('success', 'Property Type deleted successfully');
    }

    public function edit($id)
    {
        $property_type = PropertyType::findOrFail($id);


        return Inertia::render('PropertyType/Edit', ['property_type' => $property_type]);
    }
    public function update(Request $request, $id)
    {
        
        $property_type = PropertyType::find($id);
        $property_type->name = $request->name;
        $property_type->price_senior = $request->price_senior;
        $property_type->price_beginner = $request->price_beginner;
        $property_type->sale_price = $request->sale_price;
        $property_type->save();

        return redirect()->route('list.property_types')
            ->with('success', 'Property Type updated successfully');
    }
}

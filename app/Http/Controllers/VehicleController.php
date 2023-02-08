<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Vehicles\CreateUpdateRequest;
use App\Http\Resources\VehicleResource;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VehicleController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return response()->json(Vehicle::with('owner')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUpdateRequest $request)
    {
        $vehicle = Vehicle::create($request->all());
        return $this->sendResponse(new VehicleResource($vehicle), 'Vehicle created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        return $this->sendResponse(new VehicleResource($vehicle), 'Vehicle retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(CreateUpdateRequest $request, Vehicle $vehicle)
    {
        $vehicle->fill($request->all());
        $vehicle->save();
        return $this->sendResponse(new VehicleResource($vehicle), 'Vehicle retrieved successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();
        return $this->sendResponse([], 'Vehicle deleted successfully.');
    }
}

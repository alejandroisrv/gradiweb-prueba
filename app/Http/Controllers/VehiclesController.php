<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Owner;
use App\Models\Vehicle;
use App\Models\VehicleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiclesController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function getBrands(Request $request)
    {

        $brands = Brand::withCount('vehicles')->with('vehicles.owner')->get();

        $brands->map(fn ($brand) => $brand->name = ucfirst(strtolower($brand->name)));

        return response()->json($brands);
    }

    public function searchVehicle(Request $request)
    {

        $search = $request->get('search');

        $vehicle = Vehicle::with(['brand','owner','type'])->join('owners', 'owners.id', 'vehicles.owner_id')
            ->where('owners.full_name', 'like', "%{$search}%")
            ->orWhere('owners.document', 'like', "%{$search}%")
            ->orWhere('vehicles.placa', 'like', "%{$search}%")
            ->first();

        return response()->json($vehicle);
    }


    public function addNewVehicle(Request $request)
    {

        try {

            $request->validate([
                'model' => 'required|string',
                'brand' => 'required|string',
                'placa' => 'required|string',
                'owner_name' => 'required|string',
                'owner_document' => 'required|string',
                'vehicle_types' => 'required|string'
            ]);

            $data = $request->all();

            DB::beginTransaction();

            $brand = Brand::firstOrCreate(['name' => $data['brand']]);

            $owner = Owner::firstOrCreate(['full_name' => $data['owner_name'], 'document' => $data['owner_document']]);

            $vehicle_type = VehicleType::firstOrCreate(['description' => $data['vehicle_types']]);

            $vehicle = Vehicle::create([
                'model' => $data['model'],
                'owner_id' => $owner->id,
                'brand_id' => $brand->id,
                'vehicle_types_id' => $vehicle_type->id,
                'placa' =>  $data['placa']
            ]);


            DB::commit();

            return response()->json($vehicle, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function updateBrand(Request $request, $id)
    {
        $request->validate([
            'brand' => 'required|string'
        ]);


        $data = $request->all();

        $brand  = Brand::find($id);
        $brand->name = $data['brand'];
        $brand->save();

        return response()->json($brand);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Brand;
use App\Models\Owner;
use App\Models\Vehicle;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class VechileManagementTest extends TestCase
{

    use RefreshDatabase;




    public function test_list_vehicle_by_brand()
    {

        $this->withoutExceptionHandling();

        $brand = Brand::factory()->create();

        Vehicle::factory()->for($brand)->count(4)->create();

        $response = $this->get('/api/brands');

        $brands = Brand::withCount('vehicles')->with('vehicles.owner')->get();

        $response->assertStatus(200);

        $response->assertJsonFragment($brands->toArray());

        $response->assertJsonStructure([
            0 => [
                "id",
                "name",
                "vehicles",
                "vehicles_count",
            ]
        ]);
    }

    public function test_add_new_vehicle()
    {

        $this->withoutExceptionHandling();

        $response = $this->post('/api/vehicle', [
            'model' => 'Aveo',
            'brand' => 'Chevrolet',
            'placa' => 'A6GBB7',
            'owner_name' => 'Alejandro',
            'owner_document' => '1223123',
            'vehicle_types' => 'Camion',
        ]);

        $response->assertCreated();

        $vehicle = Vehicle::first();

        $response->assertJson($vehicle->toArray());
    }


    public function test_search_by_name_or_placa_or_document(){
        $this->withoutExceptionHandling();

        $brand = Brand::factory()->create();
        $owner = Owner::factory()->create();

        $newVehicle = Vehicle::factory()->for($brand)->for($owner)->create();

        $reponse = $this->get('/api/vehicles', [
            'search' => "VDVDDV"
        ]);

        $search = Vehicle::first();

        $reponse->assertJsonFragment($search->toArray());
    }


    public function test_update_brand()
    {
        $this->withoutExceptionHandling();

        $brand = Brand::factory()->create();

        $response = $this->post("/api/brand/update/{$brand->id}", [
            'brand' => 'Mazda',
        ])->assertSuccessful();

        $brand = $brand->fresh();

        $this->assertEquals($brand->name, 'Mazda');

        $response->assertJson($brand->toArray());
    }

    public function test_view_index(){
        $response = $this->get('/');
        $response->assertViewIs('index');
    }
}

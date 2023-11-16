<?php
namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PersonTest extends TestCase
{
//    use RefreshDatabase;

    public function test_index(): void
    {
        $response = $this->get('/api/person/');

        $response->assertStatus(200);
    }

    public function test_store_failure(): void
    {
        $response = $this->post('/api/person/', [
            "first_name" => "Géza",
        ]);

        $response->assertStatus(400);
    }

    public function test_store_success(): \stdClass
    {
        $response = $this->post('/api/person/', [
            "first_name" => "Géza",
            "last_name" => "Teszt"
        ]);

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        return json_decode($response->getContent());
    }

    /**
    * @depends test_store_success
    */
    public function test_update_failure($person): void
    {
        $response = $this->put("/api/person/".$person->id, []);
        $response->assertStatus(400);
    }

    public function test_update_notfound(): void
    {
        $response = $this->put("/api/person/0", []);
        $response->assertStatus(404);
    }
    
    /**
    * @depends test_store_success
    */
    public function test_update_success($person): void 
    {
        $response = $this->put("/api/person/".$person->id, ["first_name" => "Béla", "last_name" => $person->last_name]);
        $response->assertStatus(200);
        $response->assertJsonIsObject();
    }

    public function test_delete_failure(): void
    {
        $response = $this->delete("/api/person/0");
        $response->assertStatus(404);
    }

    /**
    * @depends test_store_success
    */
    public function test_delete_success($person): void
    {
        $response = $this->delete("/api/person/".$person->id);
        $response->assertStatus(200);
    }
} 
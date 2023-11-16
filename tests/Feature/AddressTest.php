<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Person;

class AddressTest extends TestCase
{
//    use RefreshDatabase;

    protected static $person;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $app = require __DIR__.'/../../bootstrap/app.php';
        $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        self::$person = Person::factory()->create();
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();
        self::$person->delete();
    }

/*
    public function setUp(): void
    {
        parent::setUp();
        self::$person = Person::factory()->create();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        self::$person->delete();
    }
*/
    public function test_index(): void
    {
        $response = $this->get('/api/person/'. self::$person->id.'/address');

        $response->assertStatus(200);
    }

    public function test_store_failure(): void
    {
        $response = $this->post('/api/person/'. self::$person->id.'/address', [
            "country" => "Magyar",
            "city" => "Kukutyin"
        ]);

        $response->assertStatus(400);
    }

    public function test_store_success(): \stdClass
    {
        $response = $this->post('/api/person/'. self::$person->id.'/address', [
            "address_type" => "permanent",
            "country" => "Magyar",
            "city" => "Kukutyin",
            "street" => "Elm",
            "number" => "16/a",
            "zip" => "1234"
        ]);

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        return json_decode($response->getContent());
    }

    /**
    * @depends test_store_success
    */
    public function test_update_failure($address): void
    {
        $response = $this->put("/api/person/". self::$person->id.'/address/'.$address->address_type, []);
        $response->assertStatus(400);
    }

    public function test_update_notfound(): void
    {
        $response = $this->put("/api/person/". self::$person->id.'/address/invalidtype', []);
        $response->assertStatus(404);
    }
    
    /**
    * @depends test_store_success
    */
    public function test_update_success($address): void 
    {
        $response = $this->put("/api/person/". self::$person->id.'/address/'.$address->address_type, [
            "country" => "England",
            "city" => "London",
            "street" => "Trafalgar",
            "number" => "26",
            "zip" => "9876"
        ]);
        $response->assertStatus(200);
        $response->assertJsonIsObject();
    }

    public function test_delete_failure(): void
    {
        $response = $this->delete("/api/person/". self::$person->id.'/address/invalidtype');
        $response->assertStatus(404);
    }

    /**
    * @depends test_store_success
    */
    public function test_delete_success($address): void
    {
        $response = $this->delete("/api/person/". self::$person->id.'/address/'.$address->address_type);
        $response->assertStatus(200);
    }
} 
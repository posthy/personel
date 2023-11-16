<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Person;

class ContactTest extends TestCase
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
        $response = $this->get('/api/person/'. self::$person->id.'/contact');

        $response->assertStatus(200);
    }

    public function test_store_failure(): void
    {
        $response = $this->post('/api/person/'. self::$person->id.'/contact', [
            "contact_type" => "email",
        ]);

        $response->assertStatus(400);
    }

    public function test_store_success(): \stdClass
    {
        $response = $this->post('/api/person/'. self::$person->id.'/contact', [
            "contact_type" => "email",
            "contact_info" => "test@mail.com"
        ]);

        $response->assertStatus(200);
        $response->assertJsonIsObject();
        return json_decode($response->getContent());
    }

    /**
    * @depends test_store_success
    */
    public function test_update_failure($contact): void
    {
        $response = $this->put("/api/person/". self::$person->id.'/contact/'.$contact->id, []);
        $response->assertStatus(400);
    }

    public function test_update_notfound(): void
    {
        $response = $this->put("/api/person/". self::$person->id.'/contact/0', []);
        $response->assertStatus(404);
    }
    
    /**
    * @depends test_store_success
    */
    public function test_update_success($contact): void 
    {
        $response = $this->put("/api/person/". self::$person->id.'/contact/'.$contact->id, [
            "contact_type" => "email",
            "contact_info" => "test_2@mail.com"
        ]);
        $response->assertStatus(200);
        $response->assertJsonIsObject();
    }

    public function test_delete_failure(): void
    {
        $response = $this->delete("/api/person/". self::$person->id.'/contact/0');
        $response->assertStatus(404);
    }

    /**
    * @depends test_store_success
    */
    public function test_delete_success($contact): void
    {
        $response = $this->delete("/api/person/". self::$person->id.'/contact/'.$contact->id);
        $response->assertStatus(200);
    }
} 
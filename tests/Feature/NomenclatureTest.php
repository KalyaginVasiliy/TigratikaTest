<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class NomenclatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_method_validates_data()
    {
        $response = $this->postJson('/api/nomenclature', [
            'name' => '',
            'quantity' => 'not_an_integer',
            'source' => '',
            'laser' => 'not_an_integer',
            'welding' => 'not_an_integer',
            'assembly' => 'not_an_integer',
            'electrical' => 'not_an_integer',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'name', 'quantity', 'source', 'laser', 'welding', 'assembly', 'electrical'
        ]);
    }
}

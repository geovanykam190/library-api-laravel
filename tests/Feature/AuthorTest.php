<?php

namespace Tests\Feature;

use App\Http\Controllers\AuthorController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// php artisan teste --filter=AuthorTest
class AuthorTest extends TestCase
{

    public function test_author(): void
    {   
        $controller = new AuthorController;
        $teste = $controller->index();
        
        // $response = $this->get('/');

        // $response->assertStatus(200);
    }
}

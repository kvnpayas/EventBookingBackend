<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
  use RefreshDatabase;

  public function test_user_can_register(): void
  {
    $response = $this->postJson('api/register', [
      'name' => 'Kevin',
      'email' => 'kvnpayas@gmail.com',
      'password' => 'password',
      'password_confirmation' => 'password'
    ]);

    $response->assertStatus(201);
  }

  public function test_user_can_login(): void
  {
    User::factory()->create([
      'email' => 'test@test.com',
      'password' => Hash::make('password')
    ]);

    $response = $this->postJson('api/login', [
      'email' => 'test@test.com',
      'password' => 'password',
    ]);

    $response->assertStatus(200)
      ->assertJsonStructure(['token']);
  }
}

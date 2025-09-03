<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;

    protected User $adminUser;
    protected User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory([
            'is_admin' => true,
        ])->create();

        $this->user = User::factory()->create();
    }
}

<?php

namespace Tests\Feature;

use App\Exceptions\UserExistsException;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{

    /**
     * @throws UserExistsException
     */
    public function testCreate(): void
    {
        $original_password = 'password';
        $user = User::factory()->make([
            Hash::make($original_password),
        ]);
        $res = resolve(UserService::class)->create([
            'name' => $user->name,
            'email' => $user->email,
            'role_id' => 1,
            'password' => $original_password,
        ]);
        $this->assertEquals($user->name, $res->name);
        $this->assertEquals($user->email, $res->email);
        $this->assertTrue(Hash::check($original_password, $res->password));
    }
}

<?php
namespace App\GraphQL\Mutations;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class Login
{
    public function __invoke($_, array $args)
    {
        $user = User::where('email', $args['email'])->first();

        if (! $user || ! Hash::check($args['password'], $user->password)) {
            throw new \Exception('Credenciales inválidas');
        }

        $token = $user->createToken('graphql-token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }
}

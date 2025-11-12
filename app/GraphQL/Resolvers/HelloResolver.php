<?php

namespace App\GraphQL\Resolvers;

class HelloResolver
{
    public function __invoke(): string
    {
        return 'Hola, Guillermo!';
    }
}

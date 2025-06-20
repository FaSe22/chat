<?php

namespace Fase\Chat\Database\Factories;

use Fase\Chat\Message;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition()
    {
        return [
            'content' => fake()->paragraph()
        ];
    }
}

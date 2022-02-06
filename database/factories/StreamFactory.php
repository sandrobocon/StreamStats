<?php

namespace Database\Factories;

use App\Models\Game;
use App\Models\Stream;
use Illuminate\Database\Eloquent\Factories\Factory;

class StreamFactory extends Factory
{
    protected $model = Stream::class;

    public function definition()
    {
        return [
            'id'            => $this->faker->unique()->randomNumber(8),
            'game_id'       => Game::factory(),
            'user_id'       => $this->faker->randomNumber(8),
            'user_login'    => $this->faker->userName(),
            'user_name'     => $this->faker->userName(),
            'game_name'     => $this->faker->name(),
            'title'         => $this->faker->word(),
            'viewer_count'  => $this->faker->randomNumber(),
            'started_at'    => $this->faker->dateTimeThisYear(),
            'language'      => $this->faker->languageCode(),
            'thumbnail_url' => $this->faker->url(),
        ];
    }
}

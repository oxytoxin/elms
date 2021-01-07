<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Message;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Message::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $u =  User::all()->random();
        $faker = FakerFactory::create();
        return [
            'sender_id' => $u->id,
            'receiver_id' => User::where('id','!=',$u->id)->get()->random()->id,
            'message' => $faker->sentence(10)
        ];
    }
}

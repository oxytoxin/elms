<?php

namespace Database\Seeders;

use App\Models\Chatroom;
use Illuminate\Database\Seeder;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $c = Chatroom::create();
        $c->members()->attach([
            4, 2
        ]);
        for ($i = 0; $i < 20; $i++) {
            if ($i % 2) {
                $c->messages()->create([
                    'sender_id' => 4,
                    'message' => 'Lorem ipsum dolor sit amet.',
                ]);
            } else {
                $c->messages()->create([
                    'sender_id' => 2,
                    'message' => 'Lorem ipsum dolor sit amet.',
                ]);
            }
        }
    }
}
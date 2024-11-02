<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;


class FillDataDbController extends Controller
{
    public function user()
    {
        // return User::create([
        //     'name' => "Steve Man",
        //     'email' => "steve@gmail.com",
        //     'password' => Hash::make("aaaAAA12!"),


        // ]);



        // Initialize Faker for generating random names and emails
        $faker = Faker::create();

        // Starting date for creation timestamps
        $startDate = Carbon::createFromFormat('Y-m-d H:i:s', '2024-10-26 21:32:56');

        // List of day offsets to apply for created_at timestamps
        $dayOffsets = [5, 9, 10, 12, 5, 8, 9];

        // Loop to create 50 users
        for ($i = 0; $i < 50; $i++) {
            // Get the current offset in the $dayOffsets array based on index
            $offsetDays = $dayOffsets[$i % count($dayOffsets)];

            // Set the created_at date by subtracting the offset days from the start date
            $createdAt = $startDate->copy()->subDays($offsetDays);

            // Create a new user with random data
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => Hash::make('aaaAAA12!'), // Static password for simplicity
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }

        return response()->json(['message' => '50 users created successfully']);
    }
}
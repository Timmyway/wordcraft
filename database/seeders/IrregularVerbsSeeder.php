<?php

namespace Database\Seeders;

use App\Models\IrregularVerb;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class IrregularVerbsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Path to the JSON file
        $jsonFilePath = database_path('seeders/datas/irregular-verbs.json');

        // Check if the file exists
        if (File::exists($jsonFilePath)) {
            // Read the file contents
            $jsonData = File::get($jsonFilePath);
            // Decode the JSON data into an array
            $irregularVerbs = json_decode($jsonData, true);

            // Check if decoding was successful and the array is not empty
            if ($irregularVerbs) {
                // Start a database transaction
                DB::transaction(function () use ($irregularVerbs) {
                    foreach ($irregularVerbs as $verb) {
                        // Use insertOrIgnore to avoid unique constraint violations
                        IrregularVerb::insertOrIgnore($verb);
                    }
                });
            } else {
                // Handle the case where JSON could not be decoded
                $this->command->error('Failed to decode JSON data.');
            }
        } else {
            // Handle the case where the file does not exist
            $this->command->error('JSON file not found: ' . $jsonFilePath);
        }

    }
}

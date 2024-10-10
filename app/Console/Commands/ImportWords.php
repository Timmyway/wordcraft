<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\WordOrSentence;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;

class ImportWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:words {filepath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import words from a CSV file into the word_or_sentences table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $filepath = $this->argument('filepath');

        // Check if the file exists
        if (!file_exists($filepath) || !is_readable($filepath)) {
            $this->error('File does not exist or is not readable.');
            return;
        }

        // Read the CSV file
        $reader = Reader::createFromPath($filepath, 'r');
        $reader->setHeaderOffset(0); // Set the header offset

        // Start the transaction for better performance
        DB::beginTransaction();

        try {
            $counter = 0;
            foreach ($reader as $record) {
                WordOrSentence::updateOrCreate(
                    ['word_or_sentence' => $record['word']], // Assuming this is the unique column
                    [
                        'pos' => $record['pos'],
                        'definition' => $record['def'],
                        'count' => $record['count'],
                        'user_id' => 1 // Set a default user_id or fetch based on your logic
                    ]
                );

                $counter ++;
                if ($counter % 1000 == 0) {
                    $this->info($counter . ' records processed... Cuurent: '. $record['word']);
                }
            }

            DB::commit(); // Commit the transaction
            $this->info('Words imported successfully.');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback if there's an error
            $this->error('Failed to import words: ' . $e->getMessage());
        }
    }
}

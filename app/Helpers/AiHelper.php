<?php
namespace App\Helpers;

use App\Helpers\General\LogHelper;
use App\Services\Google\Gemini;
use Illuminate\Support\Str;

class AiHelper
{
    public static function askToAi(string $prompt, array $options = [
        'temperature' => 1,
        'topP' => 1,
        'topK' => 1,
        'restrictionLevel' => 'safe'
    ]): string
    {
        try {
            // Initialize the Gemini API
            $gemini = new Gemini();
            $gemini->setTemperature($options['temperature']);
            $gemini->setTopP($options['topP']);
            $gemini->setTopK($options['topK']);

            // Set restriction level
            $restrictionLevel = $options['restrictionLevel'];

            // Call the Gemini API
            $result = $gemini->ask(
                $prompt = $prompt,
                restrictionLevel: $restrictionLevel,
            );

            // Process the result
            $resultText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

            // Convert Markdown to HTML if required
            if ($postData['asHtml'] ?? false) {
                $resultText = Str::markdown($resultText);
            }

            return $resultText;

        } catch (\Exception $e) {
            // Handle general exceptions
            LogHelper::error('Error in askToAi: ' . $e->getMessage());

            return '';
        }
    }
}

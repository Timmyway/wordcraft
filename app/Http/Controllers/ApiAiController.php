<?php

namespace App\Http\Controllers;

use App\Helpers\General\LogHelper;
use App\Http\Responses\SSEResponse;
use App\Models\Language;
use App\Models\Prompt;
use App\Prompts\PromptStorage;
use App\Services\Google\Gemini;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApiAiController extends Controller
{
    public function getLanguages()
    {
        $languages = Language::select(['name'])
            ->get();

        return response()->json($languages);
    }

    public static function toString(array|string $input)
    {
        // Check if input is an array
        if (is_array($input)) {
            // If array, implode and return
            return implode(', ', $input);
        } else {
            // If not an array, return input as is
            return $input;
        }
    }

    // Reusable method to handle image upload and conversion to base64
    private function handleImageUpload(Request $request, $imageName = 'image')
    {
        if ($request->hasFile($imageName)) {
            $file = $request->file($imageName);
            $path = $file->store('images');
            return $this->convertImageToBase64(storage_path('app/' . $path));
        }
        return null; // No image uploaded
    }

    private function convertImageToBase64($imagePath)
    {
        $imageData = file_get_contents($imagePath);
        return base64_encode($imageData);
    }

    public function askToAi(string $prompt, array $options = [
        'temperature' => 1,
        'topP' => 1,
        'topK' => 1,
        'restrictionLevel' => 'safe'
    ])
    {
        try {
            // Validate incoming request data
            $rules = [
                'thematic' => 'max:1000',
            ];

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

            return [
                'error' => 'An unexpected error occurred: ',
                'details' => $e->getMessage()
            ];
        }
    }
}

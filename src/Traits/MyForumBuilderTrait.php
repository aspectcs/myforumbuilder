<?php


namespace Aspectcs\MyForumBuilder\Traits;


use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

trait MyForumBuilderTrait
{

    protected function AITurbo(array $prompt)
    {
        //        Log::channel('openai')->info(' REQUEST : ' . json_encode($prompt));
        return OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $prompt
        ]);
        //        Log::channel('openai')->info(' RESPONSE : ' . json_encode($result->toArray()));
    }
}

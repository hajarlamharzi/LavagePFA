<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    public static function send($phone, $message)
    {
        try {
            $response = Http::post('http://localhost:3000/send-message', [
                'phone' => $phone,
                'message' => $message,
            ]);

            $result = $response->json();
            Log::info("[WhatsAppService] Réponse : " . json_encode($result));
            return $result;
        } catch (\Exception $e) {
            Log::error("[WhatsAppService] Erreur : " . $e->getMessage());
            return ['error' => $e->getMessage()];
        }
    }
}

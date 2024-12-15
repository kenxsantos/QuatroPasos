<?php

namespace Paymongo;

class PaymentIntent
{
    public function create($data) {
        // Set your PayMongo API key
        $apiKey = 'your_secret_api_key'; // Replace with your actual API key
        $url = 'https://api.paymongo.com/v1/payment_intents'; // PayMongo API endpoint

        // Prepare the request headers
        $headers = [
            'Authorization: Basic ' . base64_encode($apiKey . ':'),
            'Content-Type: application/json',
        ];

        // Prepare the payload for the API request
        $payload = json_encode([
            'data' => [
                'attributes' => $data
            ]
        ]);

        // Initialize cURL
        $ch = curl_init($url);

        // Set cURL options
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute the API request
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Check for cURL errors
        if (curl_errno($ch)) {
            throw new \Exception('cURL Error: ' . curl_error($ch));
        }

        // Close the cURL session
        curl_close($ch);

        // Decode the response
        $responseData = json_decode($response, true);

        // Handle the response
        if ($httpCode >= 200 && $httpCode < 300) {
            // Success, return the payment intent data
            return $responseData['data']; // Return the payment intent object
        } else {
            // Handle errors by throwing SourceError with details
            throw new SourceError($responseData['errors'][0]); // Now this will work correctly
        }
    }
}
?>
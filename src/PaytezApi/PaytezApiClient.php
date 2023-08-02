<?php

namespace YourNamespace\YourPackageName\PaytezApi;

class PaytezApiClient
{
    private $apiKey;
    private $baseUrl;

    public function __construct($apiKey, $sandbox = true)
    {
        $this->apiKey = $apiKey;
        $this->baseUrl = $sandbox ? 'https://staging.paytez.io/api/webpayment/' : 'https://paytez.io/api/webpayment/';
    }

    public function createWebPayment($invoiceAmount, $currencySymbol, $successUrl, $failureUrl)
    {
        $url = $this->baseUrl . 'create';

        $headers = array(
            'x-api-key: ' . $this->apiKey,
            'Content-Type: application/json'
        );

        $data = array(
            'invoiceAmount' => $invoiceAmount,
            'currencySymbol' => $currencySymbol,
            'successUrl' => $successUrl,
            'failureUrl' => $failureUrl
        );

        $dataJson = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpCode === 200) {
            $responseData = json_decode($response, true);

            if (isset($responseData['success']) && $responseData['success'] === true && isset($responseData['redirectLink'])) {
                // Redirect the user to the payment page
                // header("Location: " . $responseData['redirectLink']);
                return $responseData['redirectLink'];
                exit();
            } else {
                throw new \Exception('Invalid response from the API.');
            }
        } else {
            // Handle the API error or throw an exception
            throw new \Exception('Failed to create web payment. HTTP status code: ' . $httpCode);
        }
    }

    public function verifyWebPayment($invoiceNo)
    {
        $url = $this->baseUrl . 'verify';

        $headers = array(
            'x-api-key: ' . $this->apiKey,
            'Content-Type: application/json'
        );

        $data = array(
            'invoiceNo' => $invoiceNo
        );

        $dataJson = json_encode($data);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataJson);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($httpCode === 200) {
            $responseData = json_decode($response, true);

            // Process the verification response as needed (e.g., return, store in database, etc.)
            return $responseData;
        } else {
            // Handle the API error or throw an exception
            throw new \Exception('Failed to verify web payment. HTTP status code: ' . $httpCode);
        }
    }
}

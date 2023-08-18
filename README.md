```markdown
# PAYTez PHP SDK

The PAYTez PHP SDK provides a convenient way to interact with the PAYTez API for handling web payments. This SDK allows you to create and verify web payments using PHP and cURL.

## Installation

You can install the PAYTez PHP SDK via Composer. Run the following command in your project's root directory:

```bash
composer require paytez/paytez-php-sdk
```

## Usage

### Using Composer:

To use the PAYTez PHP SDK with Composer, follow the steps below:

1. Include the Composer autoloader in your PHP script:

```php
require_once 'vendor/autoload.php';
```

2. Create an instance of the PaytezApiClient class with your PAYTez API key:

```php
use Paytez\PaytezApi\PaytezApiClient;

$apiKey = 'your-api-key';
$paytezClient = new PaytezApiClient($apiKey, true); // Set to true for sandbox, false for live environment
```

3. Create a Web Payment:

```php
$invoiceAmount = "10";
$currencySymbol = "USD";
$successUrl = "http://example.com/success";
$failureUrl = "http://example.com/failure";

try {
    $redirectLink = $paytezClient->createWebPayment($invoiceAmount, $currencySymbol, $successUrl, $failureUrl);
    // Redirect the user to the payment page
    header("Location: " . $redirectLink);
    //FOR LARAVEL INTEGRATION USE THIS REDIRECT
    // return redirect()->away($redirectLink);
    exit();
} catch (\Exception $e) {
    // Handle any exceptions that may occur during the API call
    echo "Error: " . $e->getMessage();
}
```

4. Verify a Web Payment:

```php
$invoiceNo = "123456";

try {
    $verificationResult = $paytezClient->verifyWebPayment($invoiceNo);
    // Process the verification result as needed
    var_dump($verificationResult);
} catch (\Exception $e) {
    // Handle any exceptions that may occur during the API call
    echo "Error: " . $e->getMessage();
}
```

### Without Using Composer:

To use the PAYTez PHP SDK without Composer, follow these steps:

1. Download the SDK Files:
   Download the PAYTez PHP SDK files, including all the PHP files and the `src` folder containing the classes.
   https://github.com/unpyn/paytez-php-sdk

2. Include the SDK Files:
   Include the necessary SDK files in your PHP script using the `require_once` or `include_once` statements. Make sure to adjust the paths according to your project's file structure.

   For example:
   ```php
   // Replace 'path/to/paytez-php-sdk/src/' with the actual path to the SDK files
   require_once 'path/to/paytez-php-sdk/src/PaytezApi/PaytezApiClient.php';
   ```

3. Create an Instance of PaytezApiClient:
   Create an instance of the `PaytezApiClient` class with your PAYTez API key. Also, specify whether you want to use the sandbox or live environment.

   For example:
   ```php
   $apiKey = 'your-api-key';
   $paytezClient = new Paytez\PaytezApi\PaytezApiClient($apiKey, true); // Set to true for sandbox, false for live environment
   ```

4. Use the Package's Methods:
   Now, you can use the methods provided by the PAYTez PHP SDK, such as `createWebPayment` and `verifyWebPayment`, in your PHP code.

   For example:
   ```php
   // Create a Web Payment
   $invoiceAmount = "10";
   $currencySymbol = "USD";
   $successUrl = "http://example.com/success";
   $failureUrl = "http://example.com/failure";

   try {
       $redirectLink = $paytezClient->createWebPayment($invoiceAmount, $currencySymbol, $successUrl, $failureUrl);
       // Redirect the user to the payment page
       header("Location: " . $redirectLink);
       exit();
   } catch (\Exception $e) {
       // Handle any exceptions that may occur during the API call
       echo "Error: " . $e->getMessage();
   }

   // Verify a Web Payment
   $invoiceNo = "123456";

   try {
       $verificationResult = $paytezClient->verifyWebPayment($invoiceNo);
       // Process the verification result as needed
       var_dump($verificationResult);
   } catch (\Exception $e) {
       // Handle any exceptions that may occur during the API call
       echo "Error: " . $e->getMessage();
   }
   ```

## Requirements

- PHP 7.0 or higher
- cURL extension enabled

## License

The PAYTez PHP SDK is open-source software licensed under the [MIT License](LICENSE).

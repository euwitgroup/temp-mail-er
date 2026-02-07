<?php

// Test 1SecMail API with proper headers
$baseUrl = 'https://www.1secmail.com/api/v1/';

echo "Testing 1SecMail API with proper headers...\n\n";

// Headers
$headers = [
    'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/120.0.0.0 Safari/537.36',
    'Accept: application/json, text/plain, */*',
    'Referer: https://www.1secmail.com/',
];

// Test 1: Get domains
echo "1. Getting domains:\n";
$domainsUrl = $baseUrl . '?action=getDomainList';
echo "URL: $domainsUrl\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $domainsUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Response: $response\n\n";

if ($httpCode != 200) {
    echo "ERROR: API returned non-200 status code!\n";
    echo "The 1SecMail API might be down or blocking requests.\n\n";

    // Try alternative API endpoint
    echo "Trying alternative approach...\n";
    $testDomain = '1secmail.com';
    $testUsername = 'test' . rand(1000, 9999);
} else {
    $domains = json_decode($response, true);
    if (!empty($domains)) {
        echo "SUCCESS! Got " . count($domains) . " domains\n";
        $testDomain = $domains[0];
        $testUsername = 'test' . rand(1000, 9999);
    } else {
        echo "ERROR: No domains returned\n";
        exit;
    }
}

$testEmail = "{$testUsername}@{$testDomain}";

echo "\n2. Test email created: $testEmail\n";
echo "   Copy this email and send a test message to it from Gmail/another email!\n";
echo "   I'll wait 20 seconds...\n\n";

for ($i = 20; $i > 0; $i--) {
    echo "$i seconds remaining...\r";
    sleep(1);
}

echo "\n\n3. Checking for messages:\n";
$messagesUrl = $baseUrl . "?action=getMessages&login={$testUsername}&domain={$testDomain}";
echo "URL: $messagesUrl\n";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $messagesUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

echo "HTTP Code: $httpCode\n";
echo "Response: $response\n\n";

if ($httpCode == 200) {
    $messages = json_decode($response, true);
    if (!empty($messages)) {
        echo "SUCCESS! Found " . count($messages) . " message(s)!\n";
        echo "Messages:\n";
        print_r($messages);

        // Get full message
        if (isset($messages[0]['id'])) {
            echo "\n4. Fetching full message content:\n";
            $msgId = $messages[0]['id'];
            $msgUrl = $baseUrl . "?action=readMessage&login={$testUsername}&domain={$testDomain}&id={$msgId}";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $msgUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $msgResponse = curl_exec($ch);
            curl_close($ch);

            echo "Full message:\n";
            print_r(json_decode($msgResponse, true));
        }
    } else {
        echo "No messages found.\n";
        echo "Either:\n";
        echo "  1. No email was sent to $testEmail\n";
        echo "  2. Email hasn't arrived yet (try waiting longer)\n";
        echo "  3. 1SecMail service might have delays\n";
    }
} else {
    echo "ERROR: API request failed with HTTP $httpCode\n";
}

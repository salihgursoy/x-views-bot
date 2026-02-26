<?php
// Requirements: PHP 8+, curl
$bearer = 'YOUR_BEARER_TOKEN';
$tweetId = 'TWEET_ID';

$ch = curl_init("https://api.twitter.com/2/tweets/$tweetId?tweet.fields=public_metrics,non_public_metrics");
curl_setopt_array($ch, [
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_HTTPHEADER => [
    "Authorization: Bearer $bearer",
    "Content-Type: application/json"
  ],
]);
$res = curl_exec($ch);
$http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($http !== 200) {
  http_response_code(500);
  echo "API error: HTTP $http\n$res";
  exit;
}

$data = json_decode($res, true);
print_r($data['data']['public_metrics'] ?? []);

<?php
// save_review.php
// This file handles saving feedback to messages.json

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

// Get POST data
$inputData = json_decode(file_get_contents('php://input'), true);

if (!$inputData) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON data']);
    exit();
}

// Get visitor's IP address
function getVisitorIP() {
    $ipKeys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'HTTP_X_FORWARDED',
        'HTTP_X_CLUSTER_CLIENT_IP',
        'HTTP_FORWARDED_FOR',
        'HTTP_FORWARDED',
        'REMOTE_ADDR'
    ];
    
    foreach ($ipKeys as $key) {
        if (array_key_exists($key, $_SERVER) === true) {
            foreach (explode(',', $_SERVER[$key]) as $ip) {
                $ip = trim($ip);
                if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false) {
                    return $ip;
                }
            }
        }
    }
    
    return $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
}

// Get browser information
function getBrowserInfo() {
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';
    $browser = 'Unknown';
    $version = 'Unknown';
    
    if (preg_match('/Firefox\/([0-9.]+)/', $userAgent, $matches)) {
        $browser = 'Firefox';
        $version = $matches[1];
    } elseif (preg_match('/Chrome\/([0-9.]+)/', $userAgent, $matches) && strpos($userAgent, 'Edg') === false) {
        $browser = 'Chrome';
        $version = $matches[1];
    } elseif (preg_match('/Safari\/([0-9.]+)/', $userAgent, $matches) && strpos($userAgent, 'Chrome') === false) {
        $browser = 'Safari';
        $version = $matches[1];
    } elseif (preg_match('/Edg\/([0-9.]+)/', $userAgent, $matches)) {
        $browser = 'Edge';
        $version = $matches[1];
    }
    
    return [
        'browser' => $browser,
        'version' => $version,
        'userAgent' => $userAgent
    ];
}

// Prepare feedback entry
$visitorIP = getVisitorIP();
$browserInfo = getBrowserInfo();

$feedbackEntry = [
    'id' => uniqid('feedback_', true),
    'timestamp' => date('Y-m-d H:i:s'),
    'rating' => $inputData['rating'] ?? 0,
    'message' => $inputData['message'] ?? '',
    'visitor' => [
        'ip' => $visitorIP,
        'city' => $inputData['city'] ?? 'Unknown',
        'region' => $inputData['region'] ?? 'Unknown',
        'country' => $inputData['country'] ?? 'Unknown',
        'latitude' => $inputData['latitude'] ?? 'Unknown',
        'longitude' => $inputData['longitude'] ?? 'Unknown',
        'timezone' => $inputData['timezone'] ?? 'Unknown'
    ],
    'device' => [
        'browser' => $browserInfo['browser'],
        'browserVersion' => $browserInfo['version'],
        'userAgent' => $browserInfo['userAgent'],
        'platform' => $inputData['platform'] ?? 'Unknown',
        'language' => $inputData['language'] ?? 'Unknown',
        'screenResolution' => $inputData['screenResolution'] ?? 'Unknown'
    ]
];

// File path for messages.json
$jsonFile = 'messages.json';

// Read existing data or create new array
if (file_exists($jsonFile)) {
    $jsonContent = file_get_contents($jsonFile);
    $allFeedback = json_decode($jsonContent, true);
    
    if (!is_array($allFeedback)) {
        $allFeedback = [];
    }
} else {
    $allFeedback = [];
}

// Add new feedback
$allFeedback[] = $feedbackEntry;

// Save to file
$jsonData = json_encode($allFeedback, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

if (file_put_contents($jsonFile, $jsonData)) {
    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Feedback saved successfully!',
        'feedbackId' => $feedbackEntry['id']
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Failed to save feedback'
    ]);
}
?>

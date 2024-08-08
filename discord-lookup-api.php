<?php

function fetchApiData($url, $headers = []) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($ch);
    if ($response === false) {
        $error = curl_error($ch);
        curl_close($ch);
        die("cURL Error: {$error}");
    }

    curl_close($ch);

    return json_decode($response, true);
}

$token = 'TR: kendi botunuzun tokenini girin. EN: insert your bot token here';
$type = $_GET['type'] ?? null;
$id = $_GET['id'] ?? null;

if (!$type || !$id) {
    die('Error: TR: type ve id parametreleri zorunludur. EN: type and id parameters are required.');
}

$headers = [
    'Content-Type: application/json',
    "Authorization: Bot {$token}"
];

switch ($type) {
    case 'user':
        $url = "https://canary.discord.com/api/v10/users/{$id}";
        $data = fetchApiData($url, $headers);
        if (isset($data['message'])) {
            die("Error: {$data['message']}");
        }

        $output = [
            'id' => $data['id'],
            'creation_date' => date('Y-m-d\TH:i:s.v\Z', ((int)$data['id'] / 4194304) + 1420070400000), // Snowflake to Date
            'username' => $data['username'],
            'avatar' => [
                'id' => $data['avatar'],
                'link' => $data['avatar'] ? "https://cdn.discordapp.com/avatars/{$data['id']}/{$data['avatar']}" : null,
                'animated' => $data['avatar'] && strpos($data['avatar'], 'a_') === 0,
            ],
            'avatar_decoration' => $data['avatar_decoration_data'],
            'badges' => getPublicFlags($data['public_flags']),
            'premium_type' => getPremiumType($data['premium_type']),
            'accent_color' => $data['accent_color'],
            'global_name' => $data['global_name'],
            'banner' => [
                'id' => $data['banner'],
                'link' => $data['banner'] ? "https://cdn.discordapp.com/banners/{$data['id']}/{$data['banner']}?size=480" : null,
                'animated' => $data['banner'] && strpos($data['banner'], 'a_') === 0,
                'color' => $data['banner_color'],
            ],
            'data' => $data
        ];
        break;
    case 'bot':
        $url = "https://canary.discord.com/api/v10/applications/{$id}/rpc";
        $data = fetchApiData($url);
        if (isset($data['message'])) {
            die("Error: {$data['message']}");
        }

        $output = [
            'id' => $data['id'],
            'name' => $data['name'],
            'icon' => $data['icon'],
            'description' => $data['description'],
            'summary' => $data['summary'],
            'type' => $data['type'],
            'is_monetized' => $data['is_monetized'],
            'hook' => $data['hook'],
            'guild_id' => $data['guild_id'],
            'storefront_available' => $data['storefront_available'],
            'bot_public' => $data['bot_public'],
            'bot_require_code_grant' => $data['bot_require_code_grant'],
            'terms_of_service_url' => $data['terms_of_service_url'],
            'privacy_policy_url' => $data['privacy_policy_url'],
            'install_params' => $data['install_params'],
            'integration_types_config' => $data['integration_types_config'],
            'verify_key' => $data['verify_key'],
            'flags' => $data['flags'],
            'tags' => $data['tags']
        ];
        break;
    case 'server':
        $url = "https://canary.discord.com/api/v10/guilds/{$id}/widget.json";
        $data = fetchApiData($url);
        if (isset($data['message'])) {
            die("Error: {$data['message']}");
        }

        $output = [
            'id' => $data['id'],
            'name' => $data['name'],
            'instant_invite' => $data['instant_invite'],
            'presence_count' => $data['presence_count']
        ];
        break;
    default:
        die('Error: Invalid type parameter.');
}

header('Content-Type: application/json; charset=utf-8');
echo json_encode($output, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

function getPublicFlags($flags) {
    $USER_FLAGS = [
        1 => 'DISCORD_EMPLOYEE',
        2 => 'PARTNERED_SERVER_OWNER',
        4 => 'HYPESQUAD_EVENTS',
        8 => 'BUG_HUNTER_LEVEL_1',
        64 => 'HOUSE_BRAVERY',
        128 => 'HOUSE_BRILLIANCE',
        256 => 'HOUSE_BALANCE',
        512 => 'EARLY_SUPPORTER',
        16384 => 'BUG_HUNTER_LEVEL_2',
        131072 => 'VERIFIED_BOT',
        262144 => 'EARLY_VERIFIED_BOT_DEVELOPER',
        524288 => 'DISCORD_CERTIFIED_MODERATOR',
        4194304 => 'ACTIVE_DEVELOPER'
    ];

    $publicFlags = [];
    foreach ($USER_FLAGS as $bit => $flag) {
        if ($flags & $bit) {
            $publicFlags[] = $flag;
        }
    }

    return $publicFlags;
}

function getPremiumType($type) {
    $premiumTypes = [
        0 => 'None',
        1 => 'Nitro Classic',
        2 => 'Nitro',
        3 => 'Nitro Basic'
    ];

    return $premiumTypes[$type] ?? 'Unknown';
}

?>

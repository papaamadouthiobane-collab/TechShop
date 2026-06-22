<?php
$secret_key = "techshop_secret_key_2026";

function base64UrlEncode(string $data): string {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

// Génère un vrai JWT (HS256)
function genererToken($user_id, $email, $role): string {
    global $secret_key;

    $header = [
        'alg' => 'HS256',
        'typ' => 'JWT',
    ];

    $payload = [
        'id' => (int) $user_id,
        'email' => (string) $email,
        'role' => (string) $role,
        'exp' => time() + 86400,
        'iat' => time(),
    ];

    $segments = [];
    $segments[] = base64UrlEncode(json_encode($header, JSON_UNESCAPED_UNICODE));
    $segments[] = base64UrlEncode(json_encode($payload, JSON_UNESCAPED_UNICODE));

    $signingInput = $segments[0] . '.' . $segments[1];
    $signature = hash_hmac('sha256', $signingInput, $secret_key, true);
    $segments[] = base64UrlEncode($signature);

    return $segments[0] . '.' . $segments[1] . '.' . $segments[2];
}

function verifierToken(string $token): ?array {
    global $secret_key;

    if (empty($token)) {
        return null;
    }

    $parts = explode('.', $token);
    if (count($parts) !== 3) {
        return null;
    }

    [$encodedHeader, $encodedPayload, $encodedSignature] = $parts;

    $padding = 3 - ((strlen($encodedSignature) + 3) % 4);
    $signature = base64_decode(strtr($encodedSignature, '-_', '+/') . str_repeat('=', $padding));

    $signingInput = $encodedHeader . '.' . $encodedPayload;
    $expectedSignature = hash_hmac('sha256', $signingInput, $secret_key, true);

    if (!hash_equals($expectedSignature, $signature)) {
        return null;
    }

    $payloadPadding = 3 - ((strlen($encodedPayload) + 3) % 4);
    $payloadJson = base64_decode(strtr($encodedPayload, '-_', '+/') . str_repeat('=', $payloadPadding));
    $decoded = json_decode($payloadJson, true);

    if (!$decoded || !isset($decoded['exp']) || (int) $decoded['exp'] <= time()) {
        return null;
    }

    return $decoded;
}
?>


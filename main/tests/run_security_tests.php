<?php

/**
 * Standalone Security & Attack Prevention Test Suite
 * Tests all attack vectors against the contact form before inserting into DB.
 */

require_once __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\ContactMessage;
use App\Services\ContactSecurityService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

echo "=======================================================\n";
echo "   CONTACT FORM SECURITY & ATTACK SIMULATION SUITE     \n";
echo "=======================================================\n\n";

$passed = 0;
$failed = 0;

function assertTest(string $description, bool $condition, ?string $detail = null): void
{
    global $passed, $failed;
    if ($condition) {
        $passed++;
        echo " [PASS] " . $description . "\n";
    } else {
        $failed++;
        echo " [FAIL] " . $description . ($detail ? " ($detail)" : "") . "\n";
    }
}

$security = new ContactSecurityService();

// -----------------------------------------------------------------------------
// TEST 1: CAPTCHA Generation & Randomness
// -----------------------------------------------------------------------------
session()->flush();
$q1 = $security->generateCaptcha();
$ans1 = session('contact_captcha_answer');
$q2 = $security->generateCaptcha();
$ans2 = session('contact_captcha_answer');

assertTest(
    "1. Dynamic CAPTCHA generation stores valid answer in session",
    !empty($q1) && is_int($ans1) && !empty($q2) && is_int($ans2)
);

// -----------------------------------------------------------------------------
// TEST 2: CAPTCHA Replay Attack Prevention (One-time use)
// -----------------------------------------------------------------------------
$q = $security->generateCaptcha();
$correct = session('contact_captcha_answer');
$firstAttempt = $security->verifyCaptcha((string) $correct);
$secondAttempt = $security->verifyCaptcha((string) $correct);

assertTest(
    "2. Anti-Replay: CAPTCHA answer can only be used once",
    $firstAttempt === true && $secondAttempt === false
);

// -----------------------------------------------------------------------------
// TEST 3: Invalid & Empty CAPTCHA Rejection
// -----------------------------------------------------------------------------
$security->generateCaptcha();
$wrongAttempt = $security->verifyCaptcha("99999");
assertTest(
    "3. Invalid CAPTCHA answer is rejected",
    $wrongAttempt === false
);

// -----------------------------------------------------------------------------
// TEST 4: Bot Honeypot Defense
// -----------------------------------------------------------------------------
assertTest(
    "4a. Clean honeypot (human) is allowed",
    $security->isBotHoneypotTriggered("") === false && $security->isBotHoneypotTriggered(null) === false
);
assertTest(
    "4b. Populated honeypot (spambot) is flagged and trapped",
    $security->isBotHoneypotTriggered("http://spambot.xyz") === true
);

// -----------------------------------------------------------------------------
// TEST 5: Time-Lock Defense (< 2 seconds headless script)
// -----------------------------------------------------------------------------
assertTest(
    "5a. Submission under 2 seconds is blocked",
    $security->isTimeLockViolated(now()->timestamp) === true
);
assertTest(
    "5b. Submission after 3 seconds is permitted",
    $security->isTimeLockViolated(now()->timestamp - 3) === false
);

// -----------------------------------------------------------------------------
// TEST 6: XSS (Cross-Site Scripting) Payload Sanitization
// -----------------------------------------------------------------------------
$xssPayload = [
    'name' => "<script>alert('XSS_NAME')</script>John Doe",
    'email' => "user@example.com",
    'subject' => "<iframe src=x></iframe>Inquiry",
    'message' => "<script>document.cookie='steal'</script>Hello <img src=x onerror=alert(1)>World",
];

$sanitized = $security->sanitizeAndValidate($xssPayload);
assertTest(
    "6. XSS defense: Strips script, iframe, and img tags before DB insertion",
    strpos($sanitized['name'], '<script>') === false &&
    strpos($sanitized['subject'], '<iframe') === false &&
    strpos($sanitized['message'], '<script>') === false &&
    strpos($sanitized['message'], '<img') === false &&
    strpos($sanitized['message'], 'World') !== false
);

// -----------------------------------------------------------------------------
// TEST 7: CRLF Email Header Injection Attack
// -----------------------------------------------------------------------------
$crlfPayload = [
    'name' => "Attacker\r\nBcc: victim@example.com",
    'email' => "legit@domain.com\r\nBcc: victim2@example.com",
    'subject' => "Subject\r\nInjected-Header: true",
    'message' => "Message body with CRLF allowed in body",
];

$sanitizedCrlf = $security->sanitizeAndValidate($crlfPayload);
assertTest(
    "7. CRLF injection defense: Eliminates newlines from name, email, and subject",
    strpos($sanitizedCrlf['name'], "\r") === false &&
    strpos($sanitizedCrlf['name'], "\n") === false &&
    strpos($sanitizedCrlf['email'], "\r") === false &&
    strpos($sanitizedCrlf['email'], "\n") === false &&
    strpos($sanitizedCrlf['subject'], "\r") === false &&
    strpos($sanitizedCrlf['subject'], "\n") === false
);

// -----------------------------------------------------------------------------
// TEST 8: Spam URL Flooding Defense
// -----------------------------------------------------------------------------
$spamPayload = [
    'name' => "Spam Bot",
    'email' => "bot@spam.com",
    'subject' => "Cheap offers",
    'message' => "Buy now http://site1.com and https://site2.org and http://site3.net free!",
];

$spamBlocked = false;
try {
    $security->sanitizeAndValidate($spamPayload);
} catch (\InvalidArgumentException $e) {
    $spamBlocked = true;
}

assertTest(
    "8. Spam defense: Rejects messages exceeding maximum allowed URL count",
    $spamBlocked === true
);

// -----------------------------------------------------------------------------
// TEST 9: SQL Injection Attack Simulation & DB Parameterization
// -----------------------------------------------------------------------------
$sqliPayload = [
    'name' => "Robert'); DROP TABLE contact_messages;--",
    'email' => "sqli@test.com",
    'subject' => "' OR '1'='1",
    'message' => "' UNION SELECT 1,2,3,4,5,6,7,8,9--",
    'ip_address' => '127.0.0.1',
    'user_agent' => 'SecurityTestBot',
];

$dbOk = false;
$initialCount = ContactMessage::count();

try {
    $sanitizedSqli = $security->sanitizeAndValidate($sqliPayload);
    // Insert using Eloquent ORM parameterized statements
    $record = ContactMessage::create(array_merge($sanitizedSqli, [
        'ip_address' => '127.0.0.1',
        'user_agent' => 'SecurityTestBot',
    ]));

    // Verify table was NOT dropped and query executed as parameter
    $tableExists = Schema::hasTable('contact_messages');
    $newCount = ContactMessage::count();

    // Verify inserted record retains string literally without executing
    $retrieved = ContactMessage::find($record->id);
    $stringLiteral = strpos($retrieved->name, "DROP TABLE") !== false;

    // Clean up test record
    $retrieved->delete();

    $dbOk = $tableExists && ($newCount === $initialCount + 1) && $stringLiteral;
} catch (\Exception $e) {
    $dbOk = false;
    echo "SQL Exception: " . $e->getMessage() . "\n";
}

assertTest(
    "9. SQLi defense: Parameterized queries neutralize SQL injection payloads; table remains intact",
    $dbOk
);

// -----------------------------------------------------------------------------
// SUMMARY
// -----------------------------------------------------------------------------
echo "\n-------------------------------------------------------\n";
echo "TEST RESULTS: {$passed} PASSED, {$failed} FAILED\n";
echo "-------------------------------------------------------\n";

exit($failed > 0 ? 1 : 0);

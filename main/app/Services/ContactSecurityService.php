<?php

namespace App\Services;

class ContactSecurityService
{
    private const MIN_SUBMISSION_SECONDS = 2;
    private const MAX_URLS_ALLOWED = 2;

    /**
     * Generate a new randomized arithmetic CAPTCHA and store answer in session.
     */
    public function generateCaptcha(): string
    {
        $lastQ = session('contact_captcha_last_q');
        $attempts = 0;

        do {
            $type = random_int(1, 3);
            if ($type === 1) { // Addition
                $a = random_int(2, 14);
                $b = random_int(1, 12);
                $question = "{$a} + {$b} = ?";
                $answer = $a + $b;
            } elseif ($type === 2) { // Subtraction
                $a = random_int(3, 16);
                $b = random_int(1, 10);
                if ($b > $a) {
                    [$a, $b] = [$b, $a];
                }
                $question = "{$a} - {$b} = ?";
                $answer = $a - $b;
            } else { // Small Multiplication
                $a = random_int(2, 6);
                $b = random_int(2, 5);
                $question = "{$a} × {$b} = ?";
                $answer = $a * $b;
            }
            $attempts++;
        } while ($question === $lastQ && $attempts < 10);

        session(['contact_captcha_answer' => $answer]);
        session(['contact_captcha_last_q' => $question]);
        session(['contact_rendered_at' => now()->timestamp]);

        return $question;
    }

    /**
     * Verify the user-provided CAPTCHA answer and immediately invalidate it.
     */
    public function verifyCaptcha(?string $userInput): bool
    {
        $expected = session('contact_captcha_answer');
        session()->forget('contact_captcha_answer'); // Prevent replay attacks

        if ($expected === null || $userInput === null || trim($userInput) === '') {
            return false;
        }

        return (int) trim($userInput) === (int) $expected;
    }

    /**
     * Check if the hidden honeypot field was populated by a bot.
     */
    public function isBotHoneypotTriggered(?string $honeypot): bool
    {
        return !empty(trim((string) $honeypot));
    }

    /**
     * Check if the submission occurred too quickly (< 2 seconds), indicating a headless script.
     */
    public function isTimeLockViolated(?int $renderedAt): bool
    {
        if (!$renderedAt) {
            return true;
        }
        return (now()->timestamp - $renderedAt) < self::MIN_SUBMISSION_SECONDS;
    }

    /**
     * Sanitize all inputs against XSS, CRLF header injection, and link floods.
     */
    public function sanitizeAndValidate(array $input): array
    {
        // 1. Name: strip tags, strip newlines/tabs, limit length
        $name = strip_tags(trim((string) ($input['name'] ?? '')));
        $name = preg_replace('/[\r\n\t]/', ' ', $name);

        // 2. Email: strip CRLF injection attempts, validate format
        $email = trim((string) ($input['email'] ?? ''));
        $email = preg_replace('/[\r\n]/', '', $email);

        // 3. Subject: strip tags and newlines
        $subject = strip_tags(trim((string) ($input['subject'] ?? '')));
        $subject = preg_replace('/[\r\n\t]/', ' ', $subject);

        // 4. Message: strip tags, neutralize dangerous protocols
        $message = strip_tags(trim((string) ($input['message'] ?? '')));
        $message = preg_replace('/javascript:/i', 'blocked:', $message);

        // 5. Spam link flood check: maximum 2 URLs
        $urlCount = preg_match_all('/https?:\/\//i', $message);
        if ($urlCount > self::MAX_URLS_ALLOWED) {
            throw new \InvalidArgumentException('Message contains too many links.');
        }

        return [
            'name' => mb_substr($name, 0, 120),
            'email' => mb_substr($email, 0, 160),
            'subject' => mb_substr($subject, 0, 160),
            'message' => mb_substr($message, 0, 3000),
        ];
    }
}

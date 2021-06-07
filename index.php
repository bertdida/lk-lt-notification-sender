<?php
define('ROOT_DIR', __DIR__);
require_once ROOT_DIR . '/vendor/autoload.php';

use Ramsey\Uuid\Uuid;

class NotificationSender
{
    public static function send(array $payload): void
    {
        $filename = ROOT_DIR . DIRECTORY_SEPARATOR . Uuid::uuid4();
        file_put_contents($filename, json_encode($payload));

        $scriptPath = ROOT_DIR . DIRECTORY_SEPARATOR . 'send.js';
        self::execInBackground("node {$scriptPath} {$filename}");
    }

    /**
     * Executes $command in the background (no cmd window) without
     * PHP waiting for it to finish, on both Windows and Unix.
     *
     * https://www.php.net/manual/en/function.exec.php#86329
     */
    private static function execInBackground(string $command): void
    {
        if (substr(php_uname(), 0, 7) === 'Windows') {
            pclose(popen('start /B ' . $command, 'r'));
        } else {
            exec($command . ' > /dev/null &');
        }
    }
}

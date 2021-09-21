<?php

/**
 * Class ErrorLogger
 */
class ErrorLogger
{
    public const LOG_FILE = 'logs/errors.log';

    public const SAVING_DATA_ERROR = 101;
    public const NO_REQUIRED_DATA_PROVIDED = 102;
    public const ERROR_READING_FROM_STORAGE = 103;
    public const NOT_VALID_TIMESTAMP = 104;
    public const NOT_VALID_PAGE_PROVIDED = 105;

    /**
     * Main error messages / templates
     */
    private const ERROR_MESSAGES = [
        self::SAVING_DATA_ERROR => 'Unable to save data',
        self::NO_REQUIRED_DATA_PROVIDED => 'Fields - %s not provided in request',
        self::ERROR_READING_FROM_STORAGE => 'Unable to read storage data: %s',
        self::NOT_VALID_TIMESTAMP => 'Provided timestamp is not valid',
        self::NOT_VALID_PAGE_PROVIDED => "Provided page '%s' is not valid"
    ];

    /**
     * @var array
     */
    private static array $currentErrors = [];

    /**
     * @param int $errCode
     * @param array $options
     */
    public static function logError(int $errCode, array $options = []): void
    {
        $timeStr = '[ ' . date('Y-m-d H:i:s') . ' ] ';
        $message = ErrorLogger::getErrorMessage($errCode, $options) . PHP_EOL;
        static::$currentErrors[$errCode] = $message;
        file_put_contents(self::LOG_FILE, $timeStr . $message, FILE_APPEND);
    }

    /**
     * @param int $errCode
     * @param array $options
     * @return string
     */
    private static function getErrorMessage(int $errCode, array $options = []): string
    {
        if (null === ($msgTemplate = self::ERROR_MESSAGES[$errCode] ?? null)) {
            return 'Undefined error';
        }

        return vsprintf($msgTemplate, $options);
    }

    /**
     * @return array
     */
    public static function getCurrentErrors(): array
    {
        return static::$currentErrors;
    }
}
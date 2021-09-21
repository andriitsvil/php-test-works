<?php

require_once __DIR__ . '/../logger/ErrorLogger.php';


/**
 * Class StorageService
 */
class StorageService
{
    /**
     * Accuracy of determining the number of online users (in seconds)
     */
    private const EXPIRE_SECONDS = 10;
    /**
     * The required number of "old" users to remove them from the file
     */
    private const OLD_USERS_LIMIT = 1;
    private const FILE = __DIR__ . '/../../storage/active_users.json';

    /**
     * @var array
     */
    private array $currentUsers;

    /**
     * storageService constructor.
     */
    public function __construct()
    {
        $this->currentUsers = $this->getCurrentUsersInStorage();
    }

    /**
     * @return array
     */
    private function getCurrentUsersInStorage(): array
    {
        if (empty($this->currentUsers)) {
            $users = json_decode(file_get_contents(self::FILE), true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                ErrorLogger::logError(ErrorLogger::ERROR_READING_FROM_STORAGE, [json_last_error_msg()]);
            }
            return $users;
        }
        return $this->currentUsers;
    }

    /**
     * @param bool $save
     */
    private function refreshStorage(bool $save): void
    {
        $counter = 0;
        foreach ($this->currentUsers as $pageName => $pageInfo) {
            foreach ($pageInfo as $ip => $ts) {
                if ($ts < (time() - self::EXPIRE_SECONDS)) {
                    $counter++;
                    unset($this->currentUsers[$pageName][$ip]);
                }
            }
        }

        if ($counter >= self::OLD_USERS_LIMIT || $save) {
            $this->save(json_encode($this->currentUsers));
        }
    }

    /**
     * @param array $user
     */
    public function saveUserToStorage(array $user): void
    {
        $save = false;
        if ($user['ts'] > (time() - self::EXPIRE_SECONDS)) {
            $save = true;
            $this->currentUsers[$user['page']][$user['remote_addr']] = $user['ts'];
        }

        $this->refreshStorage($save);
    }

    /**
     * @param string $page
     * @return int
     */
    public function getCurrentUsersAmountPerPage(string $page): int
    {
        $counter = 0;

        foreach ($this->currentUsers[$page] as $ip => $ts) {
            if ($ts > (time() - self::EXPIRE_SECONDS)) {
                $counter++;
            }
        }

        return $counter;
    }

    /**
     * @param $dataToSave
     */
    private function save($dataToSave): void
    {
        $writeResult = file_put_contents(self::FILE, $dataToSave,LOCK_EX);

        if ($writeResult === false) {
            ErrorLogger::logError(ErrorLogger::SAVING_DATA_ERROR);
        }
    }
}

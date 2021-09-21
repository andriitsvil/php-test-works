<?php

require_once 'functions/validators.php';
require_once 'application/service/StorageService.php';

/**
 * @return array
 */
function getResponseTemplate()
{
    return [
        'activeUsers' => 0,
        'serverTs' => time(),
        'errors' => []
    ];
}

function exitWithErrors()
{
    $result = getResponseTemplate();
    $result['errors'] = ErrorLogger::getCurrentErrors();
    echo json_encode($result);
    exit();
}

// READ REQUEST
$postData = json_decode(file_get_contents('php://input'), true); // read POST requests in JSON format
if (!$postData) {
    exit();
}

// VALIDATE PROVIDED DATA
$unFilledFields = allFieldsProvided(['page', 'ts'], $postData);
if (!empty($unFilledFields)) {
    ErrorLogger::logError(ErrorLogger::NO_REQUIRED_DATA_PROVIDED, [implode(', ', $unFilledFields)]);
    exitWithErrors();
}

$isTsValid = validateTimestamp($postData['ts']);
if (!$isTsValid) {
    ErrorLogger::logError(ErrorLogger::NOT_VALID_TIMESTAMP);
    exitWithErrors();
}

$pageNameValidated = validatePageName($postData['page']);
if (empty($pageNameValidated)) {
    ErrorLogger::logError(ErrorLogger::NOT_VALID_PAGE_PROVIDED, [$postData['page']]);
    exitWithErrors();
}

// CHECK AND SAVE DATA
$user = [
    'remote_addr' => $_SERVER['REMOTE_ADDR'],
    'page' => $pageNameValidated,
    'ts' => $postData['ts']
];

$storageService = new StorageService();
$storageService->saveUserToStorage($user);

// RETURN RESULTS TO CLIENT
$result = getResponseTemplate();
$result['activeUsers'] = $storageService->getCurrentUsersAmountPerPage($pageNameValidated);
$result['errors'] = ErrorLogger::getCurrentErrors();

header('Content-Type: application/json');
echo json_encode($result);


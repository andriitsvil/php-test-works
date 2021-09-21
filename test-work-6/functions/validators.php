<?php

require_once 'config/config.php';

/**
 * @param $pageName
 * @return string
 */
function validatePageName($pageName): string
{
    if (!is_string($pageName)) {
        return '';
    }
    $config = getConfig();
    
    if ($pageName == '/' . $config['domain_path'] . '/') {
        return $config['allowed_pages']['index'];
    }
    $pagePathExploded = explode('/', trim($pageName));
    $filenameWithExt = end($pagePathExploded);
    $neededFilename = substr($filenameWithExt, 0, strrpos($filenameWithExt, "."));

    return isset($config['allowed_pages'][$neededFilename]) ? $config['allowed_pages'][$neededFilename] : '';
}

/**
 * @param array $requiredFields
 * @param array $dataToCheck
 * @return array
 */
function allFieldsProvided(array $requiredFields, array $dataToCheck): array
{
    $unFilledFields = [];
    foreach ($requiredFields as $field) {
        if (!isset($dataToCheck[$field])) {
            $unFilledFields[$field] = $field;
        }
    }
    return $unFilledFields;
}

/**
 * @param $timestamp
 * @return bool
 */
function validateTimestamp($timestamp): bool
{
    if (!is_int($timestamp)) {
        return false;
    }
    return ($timestamp >= (time() - 120)) && ($timestamp < (time() + 120)) ;
}

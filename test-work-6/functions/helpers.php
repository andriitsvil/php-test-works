<?php

function getPageName(): string
{
    $uri = $_SERVER['REQUEST_URI'];

    if (strpos($uri, '.php') === false) {
        return 'Home';
    }
    $baseName = basename($uri, ".php");

    return $baseName === 'index' ? 'Home' : ucfirst($baseName);
}

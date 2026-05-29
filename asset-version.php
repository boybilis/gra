<?php
function versioned_asset($path)
{
    $file = __DIR__ . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $path);
    $version = is_file($file) ? filemtime($file) : time();

    return htmlspecialchars($path . '?v=' . $version, ENT_QUOTES, 'UTF-8');
}



<?php

function scanTheDir($dir) {
    $scanedDir = scandir($dir);
    $dirElements = array (
        'dirs'  => [],
        'files' => []
    );
    foreach ($scanedDir as $dirElement) {
        if (is_dir($dir.$dirElement)) {
            if ($dirElement !== '.' AND $dirElement !== '..') {
                $dirElements['dirs'][] = $dirElement;
            }
        } else {
            if ($dirElement !== '.' AND $dirElement !== '..') {
                $dirElements['files'][] = $dirElement;
            }
        }
    }
    echo json_encode($dirElements);
}

function saveFile() {
    
}

function getFile() {
    
}

function getCurrentDir() {
    
}

$getData = filter_input(INPUT_POST, 'dirPath', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_SANITIZE_STRING);
$rootPath = filter_input(INPUT_POST, 'rootPath', FILTER_SANITIZE_SPECIAL_CHARS, FILTER_SANITIZE_STRING);
scanTheDir($rootPath.$getData);


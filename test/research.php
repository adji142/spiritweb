<?php
    header('Content-Type: text/html; charset=utf-8');
    $folderName = $_GET['folder'];
    $fullFolderName = '../localData/epub/'.$folderName;
    $unzipDestination = '../localData/Books/'.$folderName.'/';

    $driveResult = scandir($unzipDestination);
    $data=[];
    foreach ($driveResult as $key) {
        $ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
        if (substr($key, 0,11) == 'index_split' ) {
            array_push($data, $key);
        }
    }
    // var_dump($data);
    foreach ($data as $key) {
        // echo $key;
    }
?>
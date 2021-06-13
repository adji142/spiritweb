<?php
$zip = new ZipArchive;
  
// Zip File Name
// if ($zip->open('../localData/epub/100004.epub') === TRUE) {
  
//     // Unzip Path
//     $zip->extractTo('../localData/Books/100004/');
//     $zip->close();
//     echo 'Unzipped Process Successful!';
// } else {
//     echo 'Unzipped Process failed';
// }

// Get real path for our folder
header("application/epub+zip");
$rootPath = realpath('../localData/Books/100001');

// Initialize archive object
$zip->open('100001.epub', ZipArchive::CREATE | ZipArchive::OVERWRITE);

// Create recursive directory iterator
/** @var SplFileInfo[] $files */
$files = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($rootPath),
    RecursiveIteratorIterator::LEAVES_ONLY
);

foreach ($files as $name => $file)
{
    // Skip directories (they would be added automatically)
    if (!$file->isDir())
    {
        // Get real and relative path for current file
        $filePath = $file->getRealPath();
        $relativePath = substr($filePath, strlen($rootPath) + 1);

        // Add current file to archive
        $zip->addFile($filePath, $relativePath);
    }
}

// Zip archive will be created only after closing object
$zip->close();
echo mime_content_type('100001.epub');
// ../localData/epub/
?>
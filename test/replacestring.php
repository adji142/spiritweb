<?php
	$data = array('success' => false ,'message'=>array(),'data' => array());

	// Get Epub File Name -> Generate by GET Req from Front End
	header('Content-Type: text/html; charset=utf-8');
	$folderName = $_GET['folder'];
	$fullFolderName = '../localData/epub/'.$folderName;
	$unzipDestination = '../localData/Books/'.$folderName.'/';
	// Get Meta Data

	// End Get Meta Data

	require('util.php');
	require('epub.php');
	require 'TPEpubCreator.php';

	// try{
 //        // $book = $_REQUEST['book'];
 //        // $book = str_replace('..','',$book); // no upper dirs, lowers might be supported later
 //        $epub = new EPub($fullFolderName.'.epub');
 //        var_dump($epub->Authors())."<br>";
 //        var_dump($epub->Cover());
 //        var_dump($epub->Subjects()[0]);
 //        // echo $epub->Authors()."<br>";
 //        // echo $epub->Cover()."<br>";
 //        echo $epub->Description()."<br>";
 //        // echo $epub->Subjects()."<br>";
 //        echo $epub->Publisher()."<br>";
 //        echo $epub->Copyright()."<br>";
 //        echo $epub->Language()."<br>";
 //        echo $epub->ISBN()."<br>";
 //    }catch (Exception $e){
 //        $error = $e->getMessage();
 //    }


	// Extract Epub File
	$zip = new ZipArchive;
    if ($zip->open($fullFolderName.'.epub') === TRUE) {
  
	    
	// End Extract File// Unzip Path
	    $zip->extractTo($unzipDestination);
	    $zip->close();
	    // echo 'Unzipped Process Successful!';
	} else {
	    // echo 'Unzipped Process failed';
	    $data['success'] = false;
	    $data['message'] = 'Unzipped Process failed';
	}

	// Scaning Extraction Directory
	$driveResult = scandir($unzipDestination);
	// Step 1
	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			// $oldTitle = 'style="max-width:100%" "max-height:100%"';
			// $newTitle = 'style="max-width:100%;max-height:100%"';

			$oldTitle = '<img src="cover.jpeg" alt="cover" style="max-width:100%" "max-height:100%"/>';
			$newTitle = '';

			$findBody = '<body>';
			$replaceBody = '<body style= "background-image: url(cover.jpeg);height: 100%;max-width:100%;background-position: center;background-repeat: no-repeat;background-size: 100% 100%;margin:50px;">';

			$oldAyat1 = '<!--';
			$newAyat1 = '';

			$oldAyat2 = '-->';
			$newAyat2 = '';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			$str=str_replace($oldAyat1, $newAyat1,$str);
			$str=str_replace($oldAyat2, $newAyat2,$str);
			$str=str_replace($findBody, $replaceBody,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}


	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = "background-image: url(cover.jpeg)";
			$newTitle = "background-image: url('cover.jpeg')";

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 2
	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = '<html>';
			$newTitle = '<?xml version="1.0" encoding="utf-8"?> 
<html xmlns="http://www.w3.org/1999/xhtml">';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 3

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = '<meta http-equiv=Content-Type';
			$newTitle = '<!--<meta http-equiv=Content-Type';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 4

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = '<meta name=Generator content="Microsoft Word 15 (filtered)">';
			$newTitle = '<meta name="Generator" content="Microsoft Word 15 (filtered)"/>';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = '<meta name="Generator"';
			$newTitle = '--><meta name="Generator"';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 5

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = '<style>';
			$newTitle = '<style><![CDATA[';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 6

	foreach ($driveResult as $key) {
		if ($key != 'titlepage.xhtml') {
			$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
			if ($ext == 'html' || $ext == 'xhtml') {
				// Manipulate Epub File

				$oldTitle = '</style>';
				$newTitle = ']]></style>';

				$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
				$str=str_replace($oldTitle, $newTitle,$str);
				file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
				// End Manipulate Epub File
			}
		}
	}

	// Step 7

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = '<body lang=EN-US link="#0563C1" vlink="#954F72">';
			$newTitle = '<body lang="EN-US" link="#0563C1" vlink="#954F72">';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 8

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = '<div class=WordSection1>';
			$newTitle = '<div class="WordSection1">';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 9

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = '<p class=MsoNormal';
			$newTitle = '<p class="MsoNormal"';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 10

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = '<span lang=IN';
			$newTitle = '<span lang="IN"';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 11

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = 'font-family:"Arial","sans-serif"';
			$newTitle = 'font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 12

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = '&#9668;';
			$newTitle = '◄';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 13

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = 'font-family:"Times New Roman","serif";';
			$newTitle = 'font-family:&quot;Times New Roman&quot;,&quot;serif&quot;;';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 14

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = '&nbsp;';
			$newTitle = '';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 15

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = '<![CDATA[<![CDATA[';
			$newTitle = '<![CDATA[';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 16

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = ']]>]]>';
			$newTitle = ']]>';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 17

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'html' || $ext == 'xhtml') {
			// Manipulate Epub File

			$oldTitle = '<p class="block_" lang="en">';
			$newTitle = '';

			$findTitle = '/></p>';
			$replaceTitle = '/>';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			$str=str_replace($findTitle, $replaceTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 18

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'css') {
			// Manipulate Epub File

			$oldTitle = '.block_2 {';
			$newTitle = '.block_2 {text-align:justify;';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 19

	foreach ($driveResult as $key) {
		$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
		if ($ext == 'css') {
			// Manipulate Epub File

			$oldTitle = 'class="calibre2"/>';
			$newTitle = '.block_2 {text-align:justify;';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
			// End Manipulate Epub File
		}
	}

	// Step 20 -- Remove Index
	foreach ($driveResult as $key) {
        $ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
        if ($ext == 'ncx') {
        	$oldTitle = '<navMap>';
			$newTitle = '<!--<navMap>';

			$oldTitle1 = '</navMap>';
			$newTitle1 = '</navMap>-->';

			$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldTitle, $newTitle,$str);
			$str=str_replace($oldTitle1, $newTitle1,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);
        }
        // if (substr($key, 0,11) == 'index_split' ) {
        //     array_push($data, $key);
        // }
    }

    // Step 21 -- Add index
    $oldText = '</ncx>';
    $newText = '<navMap>';

    $dataIndex=[];
    foreach ($driveResult as $key) {
    	$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
        if (substr($key, 0,11) == 'index_split' ) {
            array_push($dataIndex, $key);
        }
    }

    $index =1;
    foreach ($dataIndex as $key) {
    	$newText .= '<navPoint id="num_'.$index.'" playOrder="'.$index.'">';
    	$newText .= '<navLabel><text>Baca: Tanggal '.$index.'</text></navLabel>';
    	$newText .= '<content src="'.$key.'"/></navPoint>';
    	$index += 1;
    }
    $newText .= "</navMap></ncx>";
    // var_dump($newText);
    foreach ($driveResult as $key) {
    	$ext = pathinfo($unzipDestination.$key, PATHINFO_EXTENSION);
        if ($ext == 'ncx') {
     		$str=file_get_contents('../localData/Books/'.$folderName.'/'.$key);
			$str=str_replace($oldText, $newText,$str);
			file_put_contents('../localData/Books/'.$folderName.'/'.$key, $str);       
        }
    }
	// End Scaning Extraction Directory

	
	// Packing to Epub File
	$rootPath = realpath('../localData/Books/'.$folderName);

	// Initialize archive object
	$zip->open($fullFolderName.'.epub', ZipArchive::CREATE | ZipArchive::OVERWRITE);

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
	// End Packing to Epub File

	$pathx = "../localData/Books/".$folderName;
	removeDirectory($pathx);

	function removeDirectory($path) {

		$files = glob($path . '/*');
		foreach ($files as $file) {
			is_dir($file) ? removeDirectory($file) : unlink($file);
		}
		rmdir($path);

		return;
	}

	$data['success'] = true;

	echo json_encode($data);
?>
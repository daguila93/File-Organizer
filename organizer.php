<?php
	function getPath(){
		$dirPathRoot;
		do{
			$dirPathRoot = readline("Type a valid directory's path: ");
			//if the string is equals to '' the realpath function gives the current path.
			if ($dirPathRoot === '') {
				$dirPathRoot = 'Wrong path';
			}

		}while (!realpath($dirPathRoot));

		return $dirPathRoot;
	}

	function getFileExtension($path){
		//Create an array with all files and directories
		$array = scandir($path);
		$fileExtensions = array();

		foreach ($array as $value) {

			//disregard '.' and '..' paths
			if ($value !== '.'  && $value !== '..') {

				//take only files
				if (is_file($path.DIRECTORY_SEPARATOR.$value)) {
					//pathinfo get a lot of information about the file, you need to specify 
					$path_parts = pathinfo($value);
					//add extension to the array if it is not there.
					if(!in_array($path_parts['extension'], $fileExtensions)){
						array_push($fileExtensions, $path_parts['extension']);
					}
				}
				
			}
			
		}
		return $fileExtensions;
	}

	function createDirectory($path, $extensionsArray){
		foreach ($extensionsArray as $value) {
			mkdir($path.DIRECTORY_SEPARATOR.$value);
		}
	}

	function organizer(){
		$path = getPath();
		$fileExtensions = getFileExtension($path);
		createDirectory($path, $fileExtensions);
	}

	//C:\Users\edild\Downloads
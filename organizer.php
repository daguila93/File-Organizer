<?php

	function getPath(){
		$dirPathRoot;
		do{
			$dirPathRoot = readline("Type a valid directory's path: ");
			//if the string is equals to '' the realpath function gives the current path. 
			//So I needed to change it to a false value like: 'Wrong path'
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
			//if the directory was already created, the software will not create again
			if (!is_dir($path.DIRECTORY_SEPARATOR.$value.DIRECTORY_SEPARATOR)) {
				//create the directory
				mkdir($path.DIRECTORY_SEPARATOR.$value);
				echo "The directory $value was successfully created. \n";
			} else {
				echo "The directory $value was already created. \n";
			}
		}
	}

	function organizer(){
		$path = getPath();
		$fileExtensions = getFileExtension($path);
		createDirectory($path, $fileExtensions);
	}

	//C:\Users\edild\Downloads
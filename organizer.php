<?php

	function getPath(){
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

	function fileHandler($path, $callback){
		//Create an array with all files and directories
		$array = scandir($path);
		$genericReturn = array();

		foreach ($array as $value) {

			//disregard '.' and '..' paths
			if ($value !== '.'  && $value !== '..') {

				//take only files
				if (is_file($path.DIRECTORY_SEPARATOR.$value)) {
					//pathinfo get a lot of information about the file, you need to specify 
					$path_parts = pathinfo($value);
                    $genericReturn = $callback($path_parts, $genericReturn);
                }

			}

		}
		return $genericReturn;
	}

/**
 * @param array $path_parts
 * @param array $fileExtensions
 * @return array
 */
function getFileExtensions(array $path_parts, array $fileExtensions)
{
//add extension to the array if it is not there.
    if (!in_array($path_parts['extension'], $fileExtensions)) {
        array_push($fileExtensions, $path_parts['extension']);
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

	function moveFiles($path){

        //File chose to be moved;
        $fileToMove = realpath( DIRECTORY_SEPARATOR . 'Users' . DIRECTORY_SEPARATOR. 'edild' . DIRECTORY_SEPARATOR . 'Desktop' . DIRECTORY_SEPARATOR . 'teste' . DIRECTORY_SEPARATOR . 'R20191213.pdf');
        //Place where the File will be moved.
        $placeToMove = realpath( DIRECTORY_SEPARATOR . 'Users' . DIRECTORY_SEPARATOR. 'edild' . DIRECTORY_SEPARATOR . 'Desktop' . DIRECTORY_SEPARATOR . 'teste' . DIRECTORY_SEPARATOR . 'pdf' . DIRECTORY_SEPARATOR);

        //Unix command to move something
        $cmd = 'mv ' . $fileToMove . ' ' . $placeToMove;

        //exec() is a command that execute something
        exec($cmd, $output, $return_val);

        //test if returned success or not.
        if ($return_val == 0) {
            echo "success! \n";
        } else {
            echo "failed, aborting... \n";
        }


//         $newplace = DIRECTORY_SEPARATOR . $path['extension'] . DIRECTORY_SEPARATOR . $path['basename'];
//             if(rename($path['dirname'], $newplace)){
//                 return $newplace;
//             }
//         return null;
    }

	function organizer(){
		$path = getPath();
        $fileExtensions = fileHandler($path, 'getFileExtensions');
        createDirectory($path, $fileExtensions);
        //move files to the respective places
        fileHandler($path, 'moveFiles');
	}

	//C:\Users\edild\Downloads
    //C:\Users\edild\Desktop\teste
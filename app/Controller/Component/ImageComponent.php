<?php
    class ImageComponent extends Component {

        //Crea una imagen redimendionando la segun los parametros ($width y $height), a partir de una imagen base especificada en
        function createThumbnail($img, $newfilename, $width, $height) {
            //Check if GD extension is loaded
            if ( !extension_loaded('gd') && !extension_loaded('gd2') ) {
                trigger_error('GD is not loaded', E_USER_WARNING);
                return false;
            }
 
            //Get Image size info
            $imgInfo = getimagesize($img);
            switch ($imgInfo[2]) {
                case 1: $im = imagecreatefromgif($img); break;
                case 2: $im = imagecreatefromjpeg($img);  break;
                case 3: $im = imagecreatefrompng($img); break;
                default:  trigger_error('Unsupported filetype!', E_USER_WARNING);  break;
            }
 
            //If image dimension is smaller, do not resize
            if ($imgInfo[0] <= $width && $imgInfo[1] <= $height) {
                $nHeight = $imgInfo[1];
                $nWidth = $imgInfo[0];
            } else {
                //yeah, resize it, but keep it proportional
                if ($width/$imgInfo[0] > $height/$imgInfo[1]) {
                    $nWidth = $width;
                    $nHeight = $imgInfo[1]*($width/$imgInfo[0]);
                } else {
                    $nWidth = $imgInfo[0]*($height/$imgInfo[1]);
                    $nHeight = $height;
                }
            }
           
            $nWidth = round($nWidth);
            $nHeight = round($nHeight);
            $newImg = imagecreatetruecolor($nWidth, $nHeight);
 
            // Check if this image is PNG or GIF, then set if Transparent  
            if (($imgInfo[2] == 1) OR ($imgInfo[2]==3)) {
                imagealphablending($newImg, false);
                imagesavealpha($newImg,true);
                $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
                imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
            }
               
            imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);
 
            //Generate the file, and rename it to $newfilename
            switch ($imgInfo[2]) {
                case 1: imagegif($newImg,$newfilename); break;
                case 2: imagejpeg($newImg,$newfilename);  break;
                case 3: imagepng($newImg,$newfilename); break;
                default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
            }
   
            return $newfilename;
        }
       
       
        //----------------------------------------------------------------------------------------------------------------
       
       
        function resize($img, $width, $height) {
            $newfilename = $img;
           
            //Check if GD extension is loaded
            if ( !extension_loaded('gd') && !extension_loaded('gd2') ) {
                trigger_error('GD is not loaded', E_USER_WARNING);
                return false;
            }
 
            //Get Image size info
            $imgInfo = getimagesize($img);
            switch ($imgInfo[2]) {
                case 1: $im = imagecreatefromgif($img); break;
                case 2: $im = imagecreatefromjpeg($img);  break;
                case 3: $im = imagecreatefrompng($img); break;
                default:  trigger_error('Unsupported filetype!', E_USER_WARNING);  break;
            }
 
            //If image dimension is smaller, do not resize
            if ($imgInfo[0] <= $width && $imgInfo[1] <= $height) {
                $nHeight = $imgInfo[1];
                $nWidth = $imgInfo[0];
            } else {
                //yeah, resize it, but keep it proportional
                if ($width/$imgInfo[0] > $height/$imgInfo[1]) {
                    $nWidth = $width;
                    $nHeight = $imgInfo[1]*($width/$imgInfo[0]);
                } else {
                    $nWidth = $imgInfo[0]*($height/$imgInfo[1]);
                    $nHeight = $height;
                }
            }
           
            $nWidth = round($nWidth);
            $nHeight = round($nHeight);
            $newImg = imagecreatetruecolor($nWidth, $nHeight);
 
            /* Check if this image is PNG or GIF, then set if Transparent*/  
            if (($imgInfo[2] == 1) OR ($imgInfo[2]==3)) {
                imagealphablending($newImg, false);
                imagesavealpha($newImg,true);
                $transparent = imagecolorallocatealpha($newImg, 255, 255, 255, 127);
                imagefilledrectangle($newImg, 0, 0, $nWidth, $nHeight, $transparent);
            }
               
            imagecopyresampled($newImg, $im, 0, 0, 0, 0, $nWidth, $nHeight, $imgInfo[0], $imgInfo[1]);
 
            //Generate the file, and rename it to $newfilename
            switch ($imgInfo[2]) {
                case 1: imagegif($newImg,$newfilename); break;
                case 2: imagejpeg($newImg,$newfilename);  break;
                case 3: imagepng($newImg,$newfilename); break;
                default:  trigger_error('Failed resize image!', E_USER_WARNING);  break;
            }
   
            return $newfilename;
        }

       
        //----------------------------------------------------------------------------------------------------------------
       
        function isValidImageFileType($imageName) {
            $validImageTypes = array('gif', 'jpg', 'jpeg', 'png','GIF', 'JPG', 'JPEG', 'PNG');
           
            $splitedFileName = explode('.', $imageName);
            $fileExtension = trim(strtolower($splitedFileName[count($splitedFileName) - 1]));
           
            if (in_array($fileExtension, $validImageTypes)) {
                return true;
            } else {
                return false;
            }
        }
    }
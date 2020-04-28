<?php
function images($filename, $destpath, $key, $tsrc)
{

//thumbnail creation start//


$n_width=99;
$n_height=66;
// Starting of GIF thumb nail creation//
$add=$destpath . $filename;
if($_FILES["file"]["type"][$key]=="image/gif"){
//echo "hello";
$im=ImageCreateFromGIF($add);
$width=ImageSx($im);              // Original picture width
$height=ImageSy($im);                  // Original picture height

$ratio1=$width/$n_width;
        $ratio2=$height/$n_height;
        if($ratio1>$ratio2) {
          $thumb_w=$n_width;
          $thumb_h=$height/$ratio1;
        }
        else    {
          $thumb_h=$n_height;
          $thumb_w=$width/$ratio2;
        }
$newimage=imagecreatetruecolor($thumb_w,$thumb_h);
imagecopyresampled($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
if (function_exists("imagegif")) {
Header("Content-type: image/gif");
ImageGIF($newimage,$tsrc);
}
if (function_exists("imagejpeg")) {
Header("Content-type: image/jpeg");
ImageJPEG($newimage,$tsrc);
}
    }

// end of gif file thumb nail creation//
$n_width=99;
$n_height=66;    

// starting of JPG thumb nail creation//
if($_FILES["file"]["type"][$key]=="image/jpeg"){
     $_FILES["file"]["name"][$key]."<br>";
$im=ImageCreateFromJPEG($add);
$width=ImageSx($im);              // Original picture width
$height=ImageSy($im);                  // Original picture height

$ratio1=$width/$n_width;
        $ratio2=$height/$n_height;
        if($ratio1>$ratio2) {
          $thumb_w=$n_width;
          $thumb_h=$height/$ratio1;
        }
        else    {
          $thumb_h=$n_height;
          $thumb_w=$width/$ratio2;
        }
$newimage=imagecreatetruecolor($thumb_w,$thumb_h);               
imagecopyresampled($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
ImageJpeg($newimage,$tsrc);
chmod("$tsrc",0777);
}
//  End of png thumb nail creation ///
if($_FILES["file"]["type"][$key]=="image/png"){
//echo "hello";
$im=ImageCreateFromPNG($add);
$width=ImageSx($im);              // Original picture width
$height=ImageSy($im);                  // Original picture height

$ratio1=$width/$n_width;
        $ratio2=$height/$n_height;
        if($ratio1>$ratio2) {
          $thumb_w=$n_width;
          $thumb_h=$height/$ratio1;
        }
        else    {
          $thumb_h=$n_height;
          $thumb_w=$width/$ratio2;
        }
$newimage=imagecreatetruecolor($thumb_w,$thumb_h);
imagecopyresampled($newimage,$im,0,0,0,0,$n_width,$n_height,$width,$height);
if (function_exists("imagepng")) {
//Header("Content-type: image/png");
ImagePNG($newimage,$tsrc);
}
if (function_exists("imagejpeg")) {
//Header("Content-type: image/jpeg");
ImageJPEG($newimage,$tsrc);
}
    }

// thumbnail creation end---
    


}
?>
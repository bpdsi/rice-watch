<?php
// Load the gd2 image
$im = imagecreatefromgd2('index.php');

// Apply an effect on the image, in this 
// case negate the image if PHP 5+
if(function_exists('imagefilter'))
{
    imagefilter($im, IMG_FILTER_NEGATE);
}

// Save the image
imagegd2($im, './test_updated.gd2');
imagedestroy($im);
?>
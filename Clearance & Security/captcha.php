<?php
session_start();

// Generate a 5-character random code
$code = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 5);
$_SESSION['captcha'] = $code;

// Create a larger image (200x60 pixels)
$image = imagecreatetruecolor(200, 60);

// Define colors
$bg_start = imagecolorallocate($image, 200, 220, 255); // Light blue gradient start
$bg_end = imagecolorallocate($image, 255, 255, 255); // White gradient end
$text_color = imagecolorallocate($image, 0, 0, 0); // Black text
$line_color1 = imagecolorallocate($image, 150, 150, 150); // Gray lines
$line_color2 = imagecolorallocate($image, 100, 150, 200); // Blue lines
$dot_color = imagecolorallocate($image, 120, 120, 120); // Gray dots

// Create a gradient background
for ($y = 0; $y < 60; $y++) {
    $ratio = $y / 60;
    $r = (int)(($bg_end >> 16) * $ratio + ($bg_start >> 16) * (1 - $ratio));
    $g = (int)((($bg_end >> 8) & 0xFF) * $ratio + (($bg_start >> 8) & 0xFF) * (1 - $ratio));
    $b = (int)(($bg_end & 0xFF) * $ratio + ($bg_start & 0xFF) * (1 - $ratio));
    $gradient_color = imagecolorallocate($image, $r, $g, $b);
    imageline($image, 0, $y, 200, $y, $gradient_color);
}

// Add random wavy lines
for ($i = 0; $i < 15; $i++) {
    $x1 = rand(0, 200);
    $y1 = rand(0, 60);
    $x2 = $x1 + rand(-30, 30);
    $y2 = $y1 + rand(-15, 15);
    $color = ($i % 2 == 0) ? $line_color1 : $line_color2;
    imageline($image, $x1, $y1, $x2, $y2, $color);
}

// Add random dots
for ($i = 0; $i < 50; $i++) {
    $x = rand(0, 200);
    $y = rand(0, 60);
    imagesetpixel($image, $x, $y, $dot_color);
}

// Draw each character with slight rotation
$x_pos = 20;
for ($i = 0; $i < strlen($code); $i++) {
    $char = $code[$i];
    $angle = rand(-15, 15); // Random angle between -15 and 15 degrees
    $temp_image = imagecreatetruecolor(30, 30);
    $temp_bg = imagecolorallocate($temp_image, 255, 255, 255);
    imagefill($temp_image, 0, 0, $temp_bg);
    imagestring($temp_image, 5, 5, 5, $char, $text_color);
    $rotated = imagerotate($temp_image, $angle, 0);
    imagecolortransparent($rotated, imagecolorat($rotated, 0, 0));
    $w = imagesx($rotated);
    $h = imagesy($rotated);
    imagecopy($image, $rotated, $x_pos, 15, 0, 0, $w, $h);
    $x_pos += 30;
    imagedestroy($temp_image);
    imagedestroy($rotated);
}

// Output image
header("Content-Type: image/png");
imagepng($image);
imagedestroy($image);
?>

<?php
$img = imagecreatetruecolor(200, 200);
$bg = imagecolorallocate($img, 255, 255, 255);
$text_color = imagecolorallocate($img, 0, 0, 0);
imagefill($img, 0, 0, $bg);
imagestring($img, 5, 70, 90, 'LOGO', $text_color);
imagepng($img, '/Applications/MAMP/htdocs/botseguro/bot2/sistema1/public/img/logo.png');
imagedestroy($img);
echo 'Logo created successfully!';
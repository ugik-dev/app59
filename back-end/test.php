<?php
include('../lib/phpqrcode/qrlib.php');

$tempDir = "../qrcode/";

$codeContents = 'This Goes From File';


$fileName = '005_file_' . md5($codeContents) . '.png';

$pngAbsoluteFilePath = $tempDir . $fileName;
$urlRelativeFilePath = $tempDir . $fileName;

// generating
if (!file_exists($pngAbsoluteFilePath)) {
    QRcode::png($codeContents, $pngAbsoluteFilePath);
    echo 'File generated!';
    echo '<hr />';
} else {
    echo 'File already generated! We can use this cached file to speed up site on common codes!';
    echo '<hr />';
}

echo 'Server PNG File: ' . $pngAbsoluteFilePath;
echo '<hr />';

// displaying
echo '<img src="' . $urlRelativeFilePath . '" />';

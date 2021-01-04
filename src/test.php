<?php

declare(strict_types=1);

use Onnov\DetectEncoding\CodePage;
use Onnov\DetectEncoding\EncodingDetector;

require __DIR__ . '/../vendor/autoload.php';

$detector = new EncodingDetector();

$text = 'Проверяемый текст';

$txtWin = iconv('UTF-8', EncodingDetector::WINDOWS_1251, $text);
echo 'win: ', $detector->getEncoding($txtWin), PHP_EOL;

$txtKoi = iconv('UTF-8', EncodingDetector::KOI8_R, $text);
echo 'koi: ', $detector->getEncoding($txtKoi), PHP_EOL;

$txtIso = iconv('UTF-8', EncodingDetector::ISO_8859_5, $text);
echo 'iso: ', $detector->getEncoding($txtIso), PHP_EOL;

$detector->enableEncoding(
    [
        EncodingDetector::IBM866,
        EncodingDetector::MAC_CYRILLIC,
    ]
);

$detector->disableEncoding(
    [
        EncodingDetector::ISO_8859_5,
    ]
);

$txtIbm = iconv('UTF-8', EncodingDetector::IBM866, $text);
echo 'ibm: ', $detector->getEncoding($txtIbm), PHP_EOL;

$txtMac = iconv('UTF-8', EncodingDetector::MAC_CYRILLIC, $text);
echo 'mac: ', $detector->getEncoding($txtMac), PHP_EOL;

echo '###############################', PHP_EOL;

$cyrillicUppercase = 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФЧЦЧШЩЪЫЬЭЮЯ';
$cyrillicLowercase = 'абвгдеёжзийклмнопрстуфхцчшщъыьэюя';

$codePage = new CodePage();

foreach ($detector->getRangeModel() as $encoding => $range) {

    echo 'encoding: ', $encoding, PHP_EOL;

    $encodingRange = $codePage->getRange($cyrillicUppercase, $cyrillicLowercase, $encoding);

//    echo '- ', $range['upper'], PHP_EOL;
//    echo '- ', $encodingRange[$encoding]['upper'], PHP_EOL, PHP_EOL;
//    echo '- ', $range['lower'], PHP_EOL;
//    echo '- ', $encodingRange[$encoding]['lower'], PHP_EOL,PHP_EOL;

    echo 'Uppercase: ', $range['upper'] === $encodingRange[$encoding]['upper'] ? 'TRUE' : 'FALSE', PHP_EOL;
    echo 'Lowercase: ', $range['lower'] === $encodingRange[$encoding]['lower'] ? 'TRUE' : 'FALSE', PHP_EOL;
}

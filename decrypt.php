<?php
include __DIR__.'/secret.php';
function utf8_converter($array)
{
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = mb_convert_encoding($item, 'UTF-8');
        }
    });
 
    return $array;
}
$secret = $secret;
$string = 'RtwtRw-QRtQtR';
$strLength = strlen($string);
$strArray = [];
$strDecrypted = '';
for($i = 0; $i < $strLength; $i++){
    $strArray[] = $string[$i];
}


foreach($strArray as $index => $character){
    if(is_numeric($character)){
        (int)$character;
    }
    if(in_array($character, $secret)){
        $strDecrypted .= $secret[$character];
    }
    else{
        $strDecrypted .= $character;
    }
}

echo $strDecrypted;

?>
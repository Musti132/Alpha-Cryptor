<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<?php
$string = isset($_POST['string']) ? $_POST['string'] : '';

if(strlen($string) > 125){
    die('no');
}
$stringToEncrypt = $string;
include __DIR__.'/secret.php';
function e($string){
    echo "\n".$string."\n";
}

$savesecret = true;
$prefile = false;

$alphabet = [
    'a',
    'b',
    'c',
    'd',
    'e',
    'f',
    'g',
    'h',
    'i',
    'j',
    'k',
    'l',
    'm',
    'n',
    'o',
    'p',
    'q',
    'r',
    's',
    't',
    'u',
    'v',
    'w',
    'x',
    'y',
    'z',
    'A',
    'B',
    'C',
    'D',
    'E',
    'F',
    'G',
    'H',
    'I',
    'J',
    'K',
    'L',
    'M',
    'N',
    'O',
    'P',
    'Q',
    'R',
    'S',
    'T',
    'U',
    'V',
    'W',
    'X',
    'Y',
    'Z',
    '!',
    '#',
    '_',
    '-',
    ' ',
    '.',
    ',',
    ':',
    ';',
    1,
    2,
    3,
    4,
    5,
    6,
    7,
    8,
    9,
    0,
    '$',
    '~',
    '^',
    ')',
    '?',
    ']',
    "'",
    '*',
];


$alphaCount = count($alphabet) - 1;
$used = [];
$newArray = [];
$counter = 0;


while(true){
    $counter++;
    if(count($used) == $alphaCount+1){ break; }
    $character = mt_rand(0, $alphaCount);
    if(in_array($character, $used)) { continue; }
    else {
        $used[$character] = $character;
        $newArray[] = $alphabet[$character];
    }
}

$randomizedAlphabet = $secret;

if(!$prefile){
    $randomizedAlphabet = [];
    $counter = 0;
    foreach($alphabet as $index => $character){
        $randomizedAlphabet[$newArray[$counter]] = $character;
        $counter++;
    }
}
$savefile = file_get_contents(__DIR__.'/secret.php');
$bypass = "\\";
$flipped = array_flip($randomizedAlphabet);
if($savesecret === true && $prefile === false){
    $header = 
'<?php
$secret = [
';
    foreach($flipped as $index => $character){
        
        if($index == "'" && $index != '0'){
            $index = $bypass.$index;
        }
        if($character == "'" && $character != '0'){
            $character = $bypass.$character;
        }
        $header .= "   '{$index}' => '{$character}',\n";

    }
    $header .= "];";
file_put_contents(__DIR__.'/secret.php', $header);

}
//print_r($randomizedAlphabet);

$string = $stringToEncrypt;
$strLength = strlen($string);
$strArray = [];
function utf8_converter($array)
{
    array_walk_recursive($array, function(&$item, $key){
        if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = mb_convert_encoding($item, 'UTF-8');
        }
    });
 
    return $array;
}
$randomizedAlphabet = utf8_converter($randomizedAlphabet);

$strEncrypted = '';
for($i = 0; $i < $strLength; $i++){
    $strArray[] = $string[$i];
}

foreach($strArray as $index => $character){
    $character = mb_convert_encoding($character, "UTF-8");
    if(in_array($character, $strArray)){
        $strEncrypted .= $randomizedAlphabet[$character];
    }
    else{
        $strEncrypted .= $character;
    }
}


?>
<div class="container">
<?php echo $strEncrypted; ?>
    <form action="#" method="POST">
        <div class="form-group">
            <label for="stringLabel">String</label>
            <input type="text" class="form-control" id="stringLabel" name="string">
        </div>
        <input type="submit" class="btn btn-primary">
    </form>
</div>
<?php

class Stnc_Uploader_Helper_Data extends Mage_Core_Helper_Abstract
{

	/**
	https://github.com/stnc/upload-class/blob/master/uploader.php
* file cleaner
* temiz bir dosya ismi oluştuur turkce karekterlleri cevirir gereksizleri kaldırır
* @access puplic
* @param string
* @return string
*/
function clean_file_name($filename)
{
$bad = array(
"<!--",
"-->",
"'",
"<",
">",
'"',
'&',
'$',
'=',
';',
'?',
'/',
"%20",
"%22",
"%3c",	// <
"%253c",	// <
"%3e",	// >
"%0e",	// >
"%28",	// (
"%29",	// )
"%2528",	// (
"%26",	// &
"%24",	// $
"%3f",	// ?
"%3b",	// ;
"%3d"	// =
);

$filename = str_replace($bad, '', $filename);


$specialLetters = array(
'a' => array('á','à','â','ä','ã'),
'A' => array('Ã','Ä','Â','À','Á'),
'e' => array('é','è','ê','ë'),
'E' => array('Ë','É','È','Ê'),
'i' => array('í','ì','î','ï','ı'),
'I' => array('Î','Í','Ì','İ','Ï'),
'o' => array('ó','ò','ô','ö','õ'),
'O' => array('Õ','Ö','Ô','Ò','Ó'),
'u' => array('ú','ù','û','ü'),
'U' => array('Ú','Û','Ù','Ü'),
'c' => array('ç'),
'C' => array('Ç'),
's' => array('ş'),
'S' => array('Ş'),
'n' => array('ñ'),
'N' => array('Ñ'),
'y' => array('ÿ'),
'Y' => array('Ÿ'),
'G' => array('Ğ'),
'g' => array('ğ')
);

foreach($specialLetters as $letter => $specials){
foreach($specials as $s){
$filename = str_replace($s, $letter, $filename);
}
}

$fd = explode('.', $filename);
$uzanti = strtolower(array_pop($fd));
array_push($fd, $uzanti);
$filename = implode('.', $fd);

return preg_replace("/[^a-zA-Z0-9\-\.]/", "_", stripslashes($filename));
}

/*
aynı isimde dosya varmı , ve gereksiz karektrerler varmı temizler 
çünkü magento upload da 
RDF01503_001(1).FLV seklinde yüklenen dosya 
RDF01503_001_1_.FLV bu şekle çevriliyor 
fakat database e RDF01503_001(1).FLV olarak kayıt oluyor 
bunu önlemek için yapıldı 
*/
function new_file_name($destFile) {
     $fileInfo = pathinfo($destFile);	
			$randomize=rand(0001, 9999);
            $baseName = $fileInfo['filename'] . '.' . $fileInfo['extension'];
			 $filename=  $this->clean_file_name($baseName);
			   $fileInfo2 = pathinfo($filename);
             if ( file_exists($fileInfo['dirname'] . DS . $filename) ) {
               $baseName = $fileInfo2['filename'].  $randomize . '.' . $fileInfo2['extension'];
            }
            $destFileName = $baseName;
        return $destFileName;

}

}
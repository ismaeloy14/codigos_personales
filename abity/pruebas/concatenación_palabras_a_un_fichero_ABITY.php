<?php

//echo "Hola jiji";

//1 - leer cuantos archivos hay en carpeta "files"

//2 - por cada archivo, extraer las provincias

//3 - generar nuevo archivo php en carpeta "formatted" (uno por cada pais)

//4 - Escribir las provincias en el archivo generado en formato array asociativo

/**
 * <?php
 * return [
 *      [
 *          'name' => '$nombre',
 *          'iso_code' => 'DE-01',  //CODIGO_ISO_PAIS-contador_2_numeros
 *      ],
 *      [...],
 * ];
 */


// Array asociativo de los iso codes de cada pais de la UE (menos España)
$isoCodes = array(
    "AT", // Austria
    "BE", // Belgium
    "BG", // Bulgaria
    "HR", // Croatia
    "CY", // Cyprus
    "CZ", // Czech Republic
    "DK", // Denmark
    "EE", // Estonia
    "FI", // Finland
    "FR", // France
    "DE", // Germany
    "GR", // Greece
    "HU", // Hungary
    "IE", // Ireland
    "IT", // Italy
    "LV", // Latvia
    "LT", // Lithuania
    "LU", // Luxembourg
    "MT", // Malta
    "NL", // Netherlands
    "PO", // Poland
    "PT", // Portugal
    "RO", // Romania
    "SK", // Slovakia
    "SI", // Slovenia
    "SE", // Sweeden
    "CH", // Switzerland
    "UK" // United Kingdom
);

// Array de los ficheros creados anteriormente.

$nombresFicheros = array("austria", "belgium", "bulgaria", "croatia", "cyprus", "czech_republic", "denmark", "estonia", "finland", "france", "germany", "greece", "hungary",
    "ireland", "italy", "latvia", "lithuania", "luxembourg", "malta", "netherlands", "poland", "portugal", "romania", "slovakia", "slovenia", "sweden",
    "switzerland", "united_kingdom");



// Dentro de este for cogeremos los datos de los ficheros y luego los insertarmos en ficheros nuevos.
for($i = 0; $i < count($nombresFicheros); $i++){
    // Aqui seleccionamos el fichero.
    $fichero = "files/".$nombresFicheros[$i].".txt";

    // Cogemos el contenido del fichero principal.
    $linea = file_get_contents($fichero);


    $arrayProvincias = array(); // Aqui se guardaran las provincias con trimadas.
    
    $provincias = explode(")", $linea); // Es un array pero con las provincias sin trim.
    var_dump($provincias);

    // Recorre el array y luego pasa la palabra entera al otro array. Asi las palabras quedan "libres".
    for($j=0; $j < count($provincias)-1; $j++){
        
            // Aqui quitamos los parentesis finales y los numeros que hayan dentro.
            $arrayProvincias[$j] = trim($provincias[$j], "(0123456789)");

            // Aqui cambiamos los corchetes por los parentesis.
            $arrayProvincias[$j] = str_replace("[", "(", $arrayProvincias[$j]);
            $arrayProvincias[$j] = str_replace("]", ")", $arrayProvincias[$j]);
    
    
    
    }
    $arrayProvincias = array_map('trim', $arrayProvincias);
    var_dump($arrayProvincias);
    
    // Aqui creamos los ficheros finales. Con el fopen los abrimos. Como tiene un parametro "a", se crean y a la hora de escribir
    // en ellos, siempre se escribira al final del fichero.
    $formatted = fopen("formatted/".$nombresFicheros[$i].".php", "a");

    // NOTA: El PHP_EOL es para hacer un salto de línea.
    fwrite($formatted, "<?php" . PHP_EOL);
    fwrite($formatted, "return [" . PHP_EOL);

    for($x = 0; $x < count($arrayProvincias); $x++){

            fwrite($formatted, "\t [".PHP_EOL);
            fwrite($formatted, "\t\t 'name' => '". addcslashes($arrayProvincias[$x],'\'')."',".PHP_EOL);

            if ($x < 9){ // Este if es para valores menores que 10
                fwrite($formatted, "\t\t 'iso_code' => '".$isoCodes[$i]."-0" . ($x + 1) . "',".PHP_EOL);
            } else { // El else para valores iguales o mayores que 10
                fwrite($formatted, "\t\t 'iso_code' => '".$isoCodes[$i]."-" . ($x + 1) . "',".PHP_EOL);
            }
            fwrite($formatted, "\t ],".PHP_EOL);

    }
    // Escribimos la última línea y cerramos el fichero.
    fwrite($formatted, "];");
    fclose($formatted);

}


















/** Formatea un array en texto plano en php para ser escrito en un archivo .php
 *
 * @param array $file_content
 * @param bool $string_for_all : true para tratar todos los contenidos como string, false para mantener tipos de datos
 * @param bool $add_open_php_tag : true para insertar la sentencia de apertura de php ( <?php )
 * @param bool $return_sentence : true para agregar return en el array contenido ( return [] )
 *
 * @return string
 */
function parseArrayFileContent($file_content, $string_for_all = false,$add_open_php_tag = true, $return_sentence = true)
{
   $content = '';
   if ($add_open_php_tag)
      $content .= '<?php ' . PHP_EOL . PHP_EOL;

   if ($return_sentence)
      $content .= 'return ';

   return $content . parseArray($file_content, $string_for_all);
}

/** Formatea un array para ser mostrado en un archivo de texto
 *
 * @param array $array
 * @param bool $string_for_all
 * @param int $level
 *
 * @return string
 */
function parseArray($array, $string_for_all = false, $level = 0)
{
   $out = '';
   if (is_array($array) && !empty($array))
   {
      $array_tabulation = "";
      for($i = 0; $i < $level; $i++) {
         $array_tabulation .= "\t";
      }
      $tabulation = $array_tabulation . "\t";
      $quot_value = ( ($string_for_all) ? '\'' : '');

      $out .= '[' . PHP_EOL;
      foreach ($array as $index => $value)
      {
         $out .= $tabulation . '\'' . $index . '\'' . "\t=>\t";
         if (is_array($value))
            $out .= parseArray($value, $string_for_all, $level + 1);
         elseif(is_numeric($value))
            $out .= $quot_value . $value . $quot_value . ',' . PHP_EOL;
         elseif(is_bool($value))
            $out .= $quot_value . (($value) ? 'true' : 'false' ) . $quot_value . ',' . PHP_EOL;
         else //Por defecto se trata como string...
            $out .= '\'' . addcslashes($value,'\'') . '\'' . ',' . PHP_EOL;
      }
      $out .= $array_tabulation . ']';
   }
   else
      $out = '[' . PHP_EOL . PHP_EOL . ']';

   $out .= ( ($level === 0) ? ';' : ',' . PHP_EOL );
   return $out;
}



?>
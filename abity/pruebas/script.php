<?php

/*********** PAGINAS A VER ************/

// https://www.php.net/manual/es/function.trim.php

// https://www.php.net/manual/es/function.file.php

// https://www.php.net/manual/es/function.file-get-contents.php

// https://www.php.net/manual/es/function.file-put-contents.php

// https://www.php.net/manual/es/function.explode.php


// Esta variable pilla todo el contenido del archivo txt.
//$fichero = fopen("documento_de_prueba/documento_prueba.txt", "r");
$fichero = "documento_de_prueba/documento_prueba.txt";


// Cohgemos el contenido del fichero principal.
$linea = file_get_contents($fichero);
//var_dump($linea);
//echo $linea;
//echo trim($linea);
echo "</br>";


$arrayPalabras = array();


$palabras = explode("()", $linea);
$lenght = count($palabras);


// REcorre el array y luego pasa la palabra entera al otro array. Asi las palabras quedan "libres".
for($i=0; $i < $lenght; $i++){
    
    echo trim($palabras[$i]);
    if ($i != $lenght-1){
        $arrayPalabras[$i] = $palabras[$i];
    }

}
echo "</br>";
var_dump($arrayPalabras);



// Con el while recorremos todas las líneas del fichero y mostrarlas por pantalla con el echo.
// El fgets recoge la línea y luego la mostramos.
// Cerramos la conexion del fichero con el fclosse.


/*
while(!file_get_contents($fichero)){
    //$linea = fgets($fichero);
    $linea = file_get_contents($fichero);
    


    var_dump($linea);
    //echo $linea[];



    $trimmed = trim($linea, "()");

    $ficheroFinal = fopen("documento_final.php", "a");
    fputs($ficheroFinal, $trimmed);
    
}
fclose($ficheroFinal);

fclose($fichero);
*/
?>





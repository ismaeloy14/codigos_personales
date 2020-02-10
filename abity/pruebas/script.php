<?php

// Esta variable pilla todo el contenido del archivo txt.
//$fichero = fopen("documento_de_prueba/documento_prueba.txt", "r");
$fichero = "documento_de_prueba/documento_prueba.txt";


// Cohgemos el contenido del fichero principal.
$linea = file_get_contents($fichero);
//var_dump($linea);
//echo $linea;
//echo trim($linea);
echo "</br>";


$palabras = explode("()", $linea);
$lenght = count($palabras);

for($i=0; $i < $lenght; $i++){
    
    echo trim($palabras[$i]);

}




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





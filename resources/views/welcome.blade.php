<?php
// Código que podría lanzar una excepción  
try {  
    // Conexión a la base de datos
    $conexion = new mysqli("localhost", "root", "123qweZXC","test");

    // Verificar la conexión
    if ($conexion -> connect_errno) {
        echo "Error al conectar con MySQL: " . $conexion -> connect_error;
        exit();
    }

    // Consulta SELECT
    $sql_select = "SELECT Genero_Usuario, Edad_Usuario, Bici, Ciclo_Estacion_Retiro, Fecha_Retiro, Hora_Retiro, Fecha_Arribo, Hora_Arribo FROM ECOBICI";

    // Ejecutar la consulta
    $resultado = $conexion->query($sql_select);

    // Comprobar si se encontraron resultados
    if ($resultado->num_rows == 0) {
        // abre el archivo en modo de lectura
        $archivo = fopen('https://ecobici.cdmx.gob.mx/wp-content/uploads/2022/07/2022-01.csv', 'r');
        // Variable para descartar la primera lectura del archivo CSV debedio a que contiene el nombre de los atributos de la tabla
        $primera_vez = 0;

        // lee cada fila del archivo
        while (($fila = fgetcsv($archivo)) !== false) {
            if ($primera_vez != 0){
                // procesa los datos de cada fila y asignar los valores a las variables
                $Genero_Usuario = $fila[0]; //F
                $Edad_Usuario = $fila[1]; //35
                $Bici = $fila[2]; //11253
                $Ciclo_Estacion_Retiro = $fila[3]; //286
                $old_date = explode('/', $fila[4]);  //31/01/2022
                $new_data = $old_date[2].'-'.$old_date[1].'-'.$old_date[0];
                $Fecha_Retiro = date($new_data);
                $Hora_Retiro = $fila[5]; //17:33.0
                $Ciclo_Estacion_Arribo = $fila[6]; //75
                $old_date1 = explode('/', $fila[7]);  //31/01/2022
                $new_data1 = $old_date1[2].'-'.$old_date1[1].'-'.$old_date1[0];
                $Fecha_Arribo = date($new_data1); 
                $Hora_Arribo = $fila[8]; //24:14.0

                // Consulta INSERT con marcadores de posición
                $sql_insert = "INSERT INTO ECOBICI (Genero_Usuario, Edad_Usuario, Bici, Ciclo_Estacion_Retiro, Fecha_Retiro, Hora_Retiro, Ciclo_Estacion_Arribo, Fecha_Arribo, Hora_Arribo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

                // Preparar la consulta
                $stmt = $conexion->prepare($sql_insert);

                // Vincular los valores a los marcadores de posición
                $stmt->bind_param("siiississ", $Genero_Usuario, $Edad_Usuario, $Bici, $Ciclo_Estacion_Retiro, $Fecha_Retiro, $Hora_Retiro, $Ciclo_Estacion_Arribo,$Fecha_Arribo, $Hora_Arribo);

                // Ejecutar la consulta
                $stmt->execute();
            } else {
                $primera_vez++;
            }
        }

        // cierra el archivo
        fclose($archivo);
    }

} catch (Exception $e) {
    // Error en la conexión 
    echo $e;
}

// Consulta SELECT
$sql_tabla1 = "SELECT DAY(Fecha_Retiro) AS Dia, Genero_Usuario AS Genero, COUNT(Bici) AS Retiros
FROM ECOBICI
GROUP BY DAY(Fecha_Retiro), Genero_Usuario;";

// Ejecutar la consulta
$data = $conexion->query($sql_tabla1);

// Consulta SELECT
$sql_tabla2 = "SELECT
DAY(Fecha_Retiro) AS Dia,
CONCAT(FLOOR(Edad_Usuario/5)*5, '-', FLOOR(Edad_Usuario/5)*5+4) AS Rango,
COUNT(Bici) AS Retiros
FROM ECOBICI
GROUP BY Dia, Rango;";

// Ejecutar la consulta
$data2 = $conexion->query($sql_tabla2);

$conexion->close();
?>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ env('APP_NAME') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity: 1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity: 1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity: 1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity: 1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
        </style>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

        <style>
            body {
                font-family: 'Nunito', sans-serif;
            }
        </style>
    </head>
    <body class="antialiased">
        <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
            <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
                <div class="flex justify-center pt-8 sm:pt-0">
                   <img alt="Descripción de la imagen" width="200" src="https://cimat.repositorioinstitucional.mx/jspui/retrieve/1012">
                </div>
                <div style="display: flex; justify-content: space-between;">
                    <table class="table table-striped table-light" style="flex-basis: 30%; text-align: center">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Día</th>
                                <th scope="col">Género</th>
                                <th scope="col">Número de bicis retiradas</th>
                            </tr>
                        <tbody>
                            @foreach ($data as $row)
                            <tr> 
                                <td>{{ $row["Dia"] }}</td>
                                <td>{{ $row["Genero"] }}</td>
                                <td>{{ $row["Retiros"] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        </thead>
                    </table>
                    <table class="table table-striped table-light" style="flex-basis: 30%; text-align: center">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">Día</th>
                                <th scope="col">Rango de edad</th>
                                <th scope="col">Número de bicis retiradas</th>
                            </tr>
                        <tbody>
                            @foreach ($data2 as $row)
                            <tr> 
                                <td>{{ $row["Dia"] }}</td>
                                <td>{{ $row["Rango"] }}</td>
                                <td>{{ $row["Retiros"] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </body>
</html>
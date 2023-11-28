<?php
// Conexión a la base de datos (reemplaza con tus propios datos)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
} else {
    echo "Conexión exitosa a la base de datos.";
}

// Consulta SQL para obtener los datos de la columna "nombre"
$sql = "SELECT name_categoria FROM categorias";
$result = $conn->query($sql);

// Crear un array para almacenar los datos
$opciones = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $opciones[] = $row["name_categoria"];
    }
}

// Cerrar la conexión a la base de datos
$conn->close();
?>
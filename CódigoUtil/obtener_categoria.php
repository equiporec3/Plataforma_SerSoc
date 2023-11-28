<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "biblioteca";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo "Conexión a la base de datos NO EXITOSA!";
    die("Conexión a la base de datos fallida: " . $conn->connect_error);
}else{
    echo "Conexión a la base de datos exitosa!";
}

// Consulta SQL para obtener las frutas
$sql = "SELECT id_categoria, name_categoria FROM categorias";
$result = $conn->query($sql);

// Recorrer los resultados y generar opciones
while ($row = $result->fetch_assoc()) {
    echo '<option value="' . $row['id_categoria'] . '">' . $row['name_categoria'] . '</option>';
}

// Cierra la conexión a la base de datos
$conn->close();
?>

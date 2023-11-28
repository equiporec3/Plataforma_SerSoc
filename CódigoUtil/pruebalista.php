<!DOCTYPE html>
<html>
<head>
    <title>Lista desplegable desde SQL</title>
    <meta charset="UTF-8"> <!-- Agregar la definición de la codificación de caracteres -->
</head>
<body>
    <form>
        <?php
        // Configura la conexión a la base de datos
        $servername = "localhost"; // Cambia "tu_servidor" por "localhost"
        $username = "root"; // Cambia "tu_usuario" por "root"
        $password = ""; // Deja el campo de contraseña en blanco si no tienes una contraseña configurada
        $dbname = "biblioteca"; // Cambia "tu_base_de_datos" por "biblioteca"

        // Crea la conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Consulta SQL para obtener los datos de la tabla categorías
        $sql = "SELECT id_categoria, name_categoria FROM categorias"; // Cambia "tu_tabla" por "categorias"
        $result = $conn->query($sql);
        ?>

        <label for="seleccion">Selecciona una categoría:</label>
        <select name="seleccion">
            <?php
            // Genera las opciones de la lista desplegable
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['id_categoria'] . '">' . $row['name_categoria'] . '</option>';
            }
            ?>
        </select>
        
        <?php
        // Cierra la conexión a la base de datos
        $conn->close();
        ?>
        
        <!-- Otros elementos del formulario y botones aquí -->
    </form>
</body>
</html>

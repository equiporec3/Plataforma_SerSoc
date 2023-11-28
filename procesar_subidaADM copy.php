<?php
// Verificamos si se ha enviado un formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén ID de Usuario desde la sesión
    session_start();
    if (isset($_SESSION["k_username"])) {  
        $ti = $_SESSION["k_rol"];
        $nom = $_SESSION["k_nombre"];
        if ($ti == 0);
        else header("Location:inicio.php");
    } else {
        header("Location:inicio.php");
    }
    $id_usuario = isset($_SESSION["k_username"]) ? $_SESSION["k_username"] : null;

    if (isset($_SESSION['nombre_categoria'])) {
        // Obtén el nombre de la categoría desde la sesión
        $nombre_categoria = $_SESSION['nombre_categoria'];

        // Elimina la variable de sesión para evitar problemas en futuras peticiones
        unset($_SESSION['nombre_categoria']);
    } else {
        // Manejo de error si la variable de sesión no está presente
        echo "Error: No se encontró el nombre de la categoría.";
        exit;
    }

    // Verificar que el ID de usuario y categoría no sean nulos antes de continuar
    if ($id_usuario !== null && $nombre_categoria !== null) {

        // Verificamos si se seleccionó un archivo
        if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == 0) {
            $nombre_archivo = $_FILES["archivo"]["name"];
            $ruta_temporal = $_FILES["archivo"]["tmp_name"];

            // Verificamos si el archivo es válido (puedes agregar más validaciones)
            $extensiones_permitidas = array("pdf", "doc", "txt");
            $extension = pathinfo($nombre_archivo, PATHINFO_EXTENSION);
            if (!in_array($extension, $extensiones_permitidas)) {
                echo "El tipo de archivo no es válido.";
            } else {
                // Copia el archivo a la carpeta de destino
                // Obtén la categoría seleccionada desde el formulario
                $categoria_seleccionada = $nombre_categoria;

                // Verifica que la categoría seleccionada no sea nula o vacía antes de usarla en la ruta
                if (!empty($categoria_seleccionada)) {
                    // Modifica la ruta de manera que quede Categorias\\$categoria_seleccionada\\$fl
                    $ruta_destino = "Categorias\\" . $categoria_seleccionada . "\\" . $nombre_archivo;

                    if (copy($_FILES['archivo']['tmp_name'], $ruta_destino)) {
                        // Éxito
                        echo "El archivo se ha subido con éxito a la categoría: $categoria_seleccionada.";
                    } else {
                        echo "Error al copiar el archivo a la carpeta de destino.";
                    }  

                    // Conecta a la base de datos (ajusta los valores de conexión según tu configuración)
                    $servername = "localhost";
                    $username = "root";
                    $password = "";
                    $dbname = "biblioteca";

                    $conn = new mysqli($servername, $username, $password, $dbname);

                    if ($conn->connect_error) {
                        die("Conexión a la base de datos fallida: " . $conn->connect_error);
                    }

                    // Consulta para obtener el id_categoria basado en el nombre_categoria
                    $consulta_categoria = "SELECT id_categoria FROM categorias WHERE name_categoria = ?";
if ($stmt_categoria = $conn->prepare($consulta_categoria)) {
    $stmt_categoria->bind_param("s", $categoria_seleccionada);
    $stmt_categoria->execute();
    $stmt_categoria->bind_result($id_categoria_result);
    $stmt_categoria->fetch();
    $stmt_categoria->close();

    // Consulta para obtener el id_usuario basado en el email
    $consulta_usuario = "SELECT id_usuario FROM usuarios WHERE email = ?";
    if ($stmt_usuario = $conn->prepare($consulta_usuario)) {
        $stmt_usuario->bind_param("s", $_SESSION["k_username"]);
        $stmt_usuario->execute();
        $stmt_usuario->bind_result($id_usuario_result);
        $stmt_usuario->fetch();
        $stmt_usuario->close();

        // Inserta el archivo en la tabla "archivos"
        $sql = "INSERT INTO archivos (name_archivo, ruta, date_upload, id_usuario, id_categoria) VALUES (?, ?, NOW(), ?, ?)";

        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssii", $nombre_archivo, $ruta_destino, $id_usuario_result, $id_categoria_result);

            if ($stmt->execute()) {
                echo "El archivo " . $nombre_archivo ." se ha subido con éxito.";
                echo "En la categoría:" . $categoria_seleccionada ;
                echo "Por el usuario con ID:" . $id_usuario_result;
            } else {
                echo "Error al subir el archivo: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error de preparación de la consulta: " . $conn->error;
        }
    } else {
        echo "Error de preparación de la consulta de usuario: " . $conn->error;
    }

} else {
    echo "Error de preparación de la consulta de categoría: " . $conn->error;
}

$conn->close();

                } else {
                    echo "Error: La categoría seleccionada es nula o vacía.";
                }
            }
        } else {
            echo "Por favor, seleccione un archivo válido.";
        }
    } else {
        echo "Error: No se pudo obtener el ID de usuario o categoría.";
        echo "Id Usuario: ", $id_usuario;
        echo "Categoria: ", $id_categoria;
    }
}
?>

                          
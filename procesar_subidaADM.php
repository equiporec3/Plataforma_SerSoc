<!DOCTYPE html>
<html lang="es">
<meta charset="UTF-8">
<!-- PHP para evitar que el usuario pueda acceder si no es el tipo adecuado -->
<head>
    <title>Repositorio Bibliotecas</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    
</head>

<body>
    <!-- Encabezado -->
    <header>
      <div class="header-content">
          <img src="Imagenes/EscudoN.png" alt="Logo">
          <div class="header-text">
              <h3>BUAP</h3>
          </div>
      </div>
  </header>

  <div id="menu">
        <ul>
            <li><a href="indexADM.php">Inicio </a></li>  
            <li><a href="listado_consultaADM.php">Consulta Archivos </a></li>
            <li><a href="listado_subidaADM.php">Carga Archivos</a></li>
            <li><a href="permisosADM.php">Permisos Usuarios</a></li>
            <li><a href="modificar_perfilADM.php">Perfil</a></li>
            <li><a href="salir.php">Salir</a></li>
        </ul>
    </div>

    <!-- Sección de acceso -->
    <section id="acceso">


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
    </section>

    <!-- Sección de fondo -->
    <footer>
      <div class="footer-column">
          <h3>BUAP</h3>
      </div>
      <div class="footer-column">
          <h3>Benemérita Universidad Autónoma de Puebla</h3>
          <p>4 sur 104 Centro Histórico C.P. 72000</p>
          <p>Teléfono +52(222) 2295500 ext. 5013</p>
      </div>
      <div class="footer-column">

          <ul>
              <li><a href="https://bibliotecas.buap.mx/portal/resources/digitalLibrary">Biblioteca Digital</a></li>
              <li><a href="https://bibliotecas.buap.mx/portal/other/librariesNews">Biblionoticias</a></li>
              <li><a href="https://bibliotecas.buap.mx/portal/flipbook/">Organigrama</a></li>
              <li><a href="https://bibliotecas.buap.mx/portal/indicators/">Indicadores</a></li>
              <li><a href="https://scod.buap.mx/">SIGI</a></li>
              <li><a href="https://bibliotecas.buap.mx/portal/help/privacy">Aviso de Privacidad</a></li>

          </ul>
      </div>
      <div class="footer-column">
          <h3>Dirección General de Bibliotecas</h3>
          <p>Boulevard Valsequillo y Av. de las Torres</p>
          <p>Ciudad Universitaria. Col. San Manuel</p>
          <p>C.P. 72570</p>
          <p>Teléfono +52 (222) 2295500 Ext 2901</p>
      </div>
  </footer>
</body>

</html>

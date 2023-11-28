<?php
// PHP para evitar que el usuario pueda acceder si no es el tipo adecuado
session_start();
if (isset($_SESSION["k_username"])) {
    $ti = $_SESSION["k_rol"];
    $nom = $_SESSION["k_nombre"];
    if ($ti == 0) {
        // Configuración de conexión a la base de datos
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "biblioteca";

        // Intenta establecer la conexión
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica si hay errores en la conexión
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        // Verifica si se ha enviado un formulario
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Obtén la categoría seleccionada desde el formulario
            $id_categoria = $_POST["seleccion"];
            $id_categoria = $conn->real_escape_string($id_categoria);
        
        // Realiza una consulta para obtener el name_categoria basado en el id_categoria
        $sql_categoria = "SELECT name_categoria FROM categorias WHERE id_categoria = '$id_categoria'";
        $result_categoria = $conn->query($sql_categoria);

        if ($result_categoria->num_rows > 0) {
            // Hay al menos una fila, obtenemos el nombre de la categoría
            $row_categoria = $result_categoria->fetch_assoc();
            $nombre_categoria = $row_categoria['name_categoria'];

            // Guarda el nombre de la categoría en una sesión
            $_SESSION['nombre_categoria'] = $nombre_categoria;
            
        } else {
            // No se encontró la categoría
            echo "La categoría con ID '$id_categoria' no fue encontrada.";
            exit; // Sale del script para evitar continuar con la ejecución
        }

        ?>

            <!DOCTYPE html>
            <html lang="es">

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
                        <li><a href="listado_subidaADM.php">Carga Archivos</a></li>
                        <li><a href="permisosADM.php">Permisos Usuarios</a></li>
                        <li><a href="modificar_perfilADM.php">Perfil</a></li>
                        <li><a href="salir.php">Salir</a></li>
                    </ul>
                </div>

                <!-- Sección de acceso -->
                <section id="acceso">

                <h1>Subir Archivo a la Categoría: <?php echo htmlspecialchars($nombre_categoria); ?></h1>
                    <form action="procesar_subidaADM.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="categoria" value="<?php echo htmlspecialchars($id_categoria); ?>">
                        <label for="archivo">Seleccione un archivo:</label>
                        <input type="file" name="archivo" id="archivo" accept=".pdf, .doc, .txt">
                        <input type="submit" value="Subir Archivo">
                    </form>


                <?php
                    // Cierra la conexión a la base de datos (si es relevante para este punto del código)
                } else {
                    echo "Por favor, selecciona una categoría antes de acceder a esta página.";
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
<?php
    } else {
        header("Location:inicio.php");
    }
} else {
    header("Location:inicio.php");
}
?>

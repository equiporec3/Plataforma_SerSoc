<!DOCTYPE html>
<html lang="es">
<meta charset="UTF-8">
<!-- PHP para evitar que el usuario pueda acceder si no es el tipo adecuado -->
<?PHP
session_start();
if (isset($_SESSION["k_username"]))
  {  
     $ti=$_SESSION["k_rol"];
	 $nom=$_SESSION["k_nombre"];
     if ($ti==1);
     else header("Location:inicio.php");
  }
else header("Location:inicio.php");
?>
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
      <li><a href="indexUSER.php">Inicio </a></li>  
      <li><a href="listado_consultaUSER.php">Consulta Archivos </a></li>
      <li><a href="listado_subidaUSER.php">Carga Archivos</a></li>
      <li><a href="modificar_perfilUSER.php">Perfil</a></li>
      <li><a href="salir.php">Salir</a></li>
    </ul>
  </div>

    <!-- Sección de acceso -->
    <section id="acceso">


   <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén el id_categoria seleccionado
    $id_categoria = $_POST["seleccion"];

    // Realiza la conexión a la base de datos
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "biblioteca";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Escapa el id_categoria para evitar inyección de SQL
    $id_categoria = $conn->real_escape_string($id_categoria);

    // Realiza una consulta para obtener el name_categoria basado en el id_categoria
    $sql_categoria = "SELECT name_categoria FROM categorias WHERE id_categoria = '$id_categoria'";
    $result_categoria = $conn->query($sql_categoria);

    if ($result_categoria->num_rows > 0) {
        $row_categoria = $result_categoria->fetch_assoc();
        $categoria = $row_categoria['name_categoria'];

        // Realiza la consulta para obtener los elementos de la categoría seleccionada
        $sql = "SELECT name_archivo, date_upload, ruta, id_usuario FROM archivos WHERE id_categoria = '$id_categoria'";
        $result = $conn->query($sql);

        // Muestra los elementos recuperados en una tabla HTML
        if ($result->num_rows > 0) {
            echo "<h1>Elementos de la categoría '$categoria':</h1>";
            echo "<table>";
            echo "<tr><th>Nombre de Archivo</th><th>Fecha de Subida</th><th>Usuario</th><th>Descargar</th></tr>";
            while ($row = $result->fetch_assoc()) {
                $id_usuario = $row['id_usuario'];
                
                // Realiza una consulta para obtener el nombre del usuario basado en el id_usuario
                $sql_usuario = "SELECT email FROM usuarios WHERE id_usuario = '$id_usuario'";
                $result_usuario = $conn->query($sql_usuario);
                $row_usuario = $result_usuario->fetch_assoc();
                $nombre_usuario = $row_usuario['email'];
        
                echo "<tr>";
                echo "<td>" . $row['name_archivo'] . "</td>";
                echo "<td>" . $row['date_upload'] . "</td>";
                echo "<td>" . $nombre_usuario . "</td>";
                echo "<td><a href='" . $row['ruta'] . "' download>Descargar</a></td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "No se encontraron elementos en la categoría '$categoria'.";
        }
        
    } else {
        echo "La categoría con ID '$id_categoria' no fue encontrada.";
    }

    // Cierra la conexión a la base de datos
    $conn->close();
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

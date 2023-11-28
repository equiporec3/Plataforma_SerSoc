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
     if ($ti==0);
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
      <li><a href="listado_consultaADM.php">Consulta Archivos </a></li>
      <li><a href="listado_subidaADM.php">Carga Archivos</a></li>
      <li><a href="permisosADM.php">Permisos Usuarios</a></li>
      <li><a href="modificar_perfilADM.php">Perfil</a></li>
      <li><a href="salir.php">Salir</a></li>
    </ul>
  </div>

    <!-- Sección de acceso -->
    <section id="acceso">


    <p>Hola <?php echo $_SESSION["k_nombre"];?> <?php echo $_SESSION["k_apellidos"]; ?> </p>
    <p>Rol: <?php echo $_SESSION["k_rol"];?> </p>

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

<!DOCTYPE html>
<html lang="es">
<meta charset="UTF-8">


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

    <!-- Banner de imagen -->
    <div id="banner">
        <!-- Puedes agregar contenido adicional dentro del banner si lo deseas -->
    </div>

    <!-- Sección de acceso -->
    <section id="acceso">
      <form action="validar_usuario.php" method="post">

        <input type="email" id="inputEmail" name="Email" placeholder="Email" required="">
        
        <div class="input-container">
          <input type="password" id="inputPass" name="Pass" placeholder="Contraseña" required="">
          <button type="button" id="mostrarContrasena">Mostrar</button>
        </div>

        <a href="recoverPass1.html">¿Olvidaste tu contraseña?</a>

        <button type="submit"> Ingresar</button>
      </form>
         <a href="registro.php" class="boton">Crear cuenta nueva</a>
    </section>

    <!--Script en js para mostrar la contraseña al hacer clic en mostrar-->
    <script>
      var contrasenaInput = document.getElementById("inputPass");
      var mostrarContrasenaButton = document.getElementById("mostrarContrasena");
        
      mostrarContrasenaButton.addEventListener("click", function() {
        if (contrasenaInput.type === "password") {
          contrasenaInput.type = "text";
        } else {
          contrasenaInput.type = "password";
        }
      });
      </script>

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

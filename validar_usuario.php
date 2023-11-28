<?php session_start();
   
$usu=$_REQUEST['Email']; 
$pas=$_REQUEST['Pass'];
   $link=mysqli_connect("localhost","root",""); 
   mysqli_select_db($link,"biblioteca");
$result = mysqli_query($link,"SELECT password, email, nombre, apellidos, rol FROM usuarios WHERE email='$usu'");
   if($row = mysqli_fetch_array($result))
      {
        if($row["password"] == $pas)
           {
		    $_SESSION["k_username"] = $row['email'];
            $_SESSION["k_rol"] = $row['rol'];    
            $_SESSION["k_nombre"] = $row['nombre'];    
            $_SESSION["k_apellidos"] = $row['apellidos'];
			//$_SESSION["k_username"] = $row['usuario'];           
            if($row["rol"]==1) header("Location:indexUSER.php");
            if($row["rol"]==0) header("Location:indexADM.php");
           }
        else header("Location:passwordIncorrecto.php");	      
      }
   else header("Location:loginIncorrecto.php");
?> 
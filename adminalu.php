<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="./styles/tabla2.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>


<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid" >
  <?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
  if(!$_SESSION['login2']){
    echo "<a class='navbar-brand' href='./profeoalu.php'>Crear Usuarios</a>";
  }
  ?>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
        <?php
        if (session_status() == PHP_SESSION_NONE) {
          session_start();
        }
        if(!$_SESSION['login2']){
          echo "<a class='nav-link active' aria-current='page' href='./bajarcsvalu.php'>Bajar CSV</a>";
        }       
        ?>
        </li>
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="./adminp.php"href="">Profesores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="./admin.php" href="">Alumnos</a>
        </li>
        <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
      </ul>
      <form class="d-flex">
        <button class="btn btn-outline-success" onclick="window.location.href = './proc/proc_logout.php'" type="button">Logout</button>
      </form>
    </div>
  </div>
</nav>




<?php
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
if(!$_SESSION['login']){
    //     echo "<script> window.location='./index.php'</script>";    
}
include './proc/conexion.php';
?>
<br>

<form action="./proc/filtro_admin.php">
<div class="tabla-filtro">
<th><input class="outlinenone" type="text" maxlength="20" name="tabla_dni_alu" id="tabla_dni_alu" placeholder="DNI"></th>

                        <th><input class="outlinenone" type="text" maxlength="20 " name="tabla_nom_alu" id="tabla_nom_alu" placeholder="Nombre"></th>
                        
                        <th><input class="outlinenone" type="text" maxlength="20" name="tabla_cognom1_alu" id="tabla_cognom1_alu" placeholder="1r Apellido"></th>
                      
                        <th><input class="outlinenone" type="text" maxlength="20" name="tabla_cognom2_alu" id="tabla_cognom2_alu" placeholder="2n Apellido"></th>
                       
                        <th><input class="outlinenone" type="text" maxlength="20" name="tabla_email_alu" id="tabla_email_alu" placeholder="Correo"></th>
                       
                        <th><input class="outlinenone" type="text" maxlength="20" name="tabla_classe" id="tabla_classe" placeholder="Clase"></th>
                        
                        <th><input class="outlinenone" type="text" maxlength="20" name="tabla_telf_alu" id="tabla_telf_alu" placeholder="Telefono"></th>
                        <th><input class="outlinenone" type="submit" value="Buscar"></th>
                        </div>
                        </form>

                        
<?php
$cantPorPagina = 10;
$sql = "SELECT * FROM tbl_alumne;";
$queryAnim = mysqli_query($connection, $sql);
//mysqli_num_rows = cantidad de registros que me devuelve
$numFilas = mysqli_num_rows($queryAnim);
//                                                               -------------------------------------
//mostrar el n??mero de registros                                | si lees esto eres un nene malo jeje |
//echo $numFilas."<br>";                                         -------------------------------------

//Saber la cantidad de p??ginas seg??n la cantidad de registros por p??gina
$cantidadPaginas = ceil($numFilas/$cantPorPagina); //CEIL = Redondear al n??mero elevado (ej: 5.1 -> 6)

//Saber si estamos en la p??gina 1 u en otra
if (empty($_GET["pag"])) {
    $inicioPagina = 0;
}
else {
    $inicioPagina = ($_GET["pag"]-1)*$cantPorPagina;
}

//La query final
$sql2 = "SELECT id_alumne, dni_alu, nom_alu, cognom1_alu, cognom2_alu, telf_alu, email_alu, c.nom_classe as 'classe', passwd_alu
FROM tbl_alumne 
INNER JOIN tbl_classe c 
ON classe = c.id_classe LIMIT $inicioPagina, $cantPorPagina;";
$queryAlu = mysqli_query($connection, $sql2);

//ESTE "FOR" SE PONE DEBAJO DE LA TABLA                         ESTE "FOR" SE PONE DEBAJO DE LA TABLA

echo '<table>';
echo '<tr>';
echo '<th>DNI</th>';
echo '<th>Nombre</th>';
echo '<th>1r Apellido</th>';
echo '<th>2n Apellido</th>';
echo '<th>Correo</th>';
echo '<th>Clase</th>';
echo '<th>Telefono</th>';
echo '<th>Contrase??a</th>';
if (!$_SESSION['login2']){
echo '<th>Borrar</th>';
echo'<th>Modificar</th>';
echo'<th>Email</th>';
echo '</tr>';
}
//tabla alumnos
foreach ($queryAlu as $alumno) {
    
    // echo $rutacompleta;
    echo '<tr>';
    echo "<td>{$alumno['dni_alu']}</td>";
    echo "<td>{$alumno['nom_alu']}</td>";
    echo "<td>{$alumno['cognom1_alu']}</td>";
    echo "<td>{$alumno['cognom2_alu']}</td>";
    echo "<td>{$alumno['email_alu']}</td>";
    echo "<td>{$alumno['classe']}</td>";
    echo "<td>{$alumno['telf_alu']}</td>";
    echo "<td>{$alumno['passwd_alu']}</td>";

  if (!$_SESSION['login2']) {
    echo "<td><button type='button' class='btn btn-outline-danger' onClick=\"aviso('borrar.php?id={$alumno['id_alumne']};')\" >Borrar</button></td>";
   
    echo "<td><button type='button 'class='btn btn-outline-primary' onClick=\"aviso('modificar.php?id={$alumno['id_alumne']};')\">Modificar</button></td>";

    echo "<td><button type='button' name= 'enviarCorr'class='btn btn-outline-warning' onClick=\"aviso('correo.php?id={$alumno['id_alumne']};')\">Email</button></td>";
    
  }  
}
    echo '</table>';
      // echo "<span><a href='admin.php?pag=$i'>$i  |  </a></span>";  //Botones
    echo" <nav class='paddingl' aria-label='Page navigation example'>
      <ul class='pagination pg-blue'>
        <li class='page-item'></li>
        ";
        for($i=1;$i<=$cantidadPaginas;$i++) {
          echo "<li class='page-item'><a class='page-link' href='adminalu.php?pag=$i'>$i</a></li>
        ";
        }
      echo "</ul>";

?>

    <script>

    function aviso(url) {
         Swal.fire({
             title: '??Estas seguro?',
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#3085d6',
             cancelButtonColor: '#d33',
             confirmButtonText: 'Yes'
             }).then((result) => {
           if (result.isConfirmed) {
                window.location.href = url;
             }
             })
    }
    
    
    </script>
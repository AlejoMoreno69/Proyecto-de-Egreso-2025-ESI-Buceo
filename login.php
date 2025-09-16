<?php
session_start();

$servidor = "localhost";
$usuarioBD = "root";
$claveBD   = "";
$baseDatos = "ejemplo_login";

$conn = new mysqli($servidor, $usuarioBD, $claveBD, $baseDatos);

if ($conn->connect_error) {
    die("Error en la conexión: " . $conn->connect_error);
}

$usuario    = $_POST['usuario'];
$contrasena = $_POST['contrasena'];
$email = $_POST['email'];

// Buscar usuario en la BD
$sql = "SELECT * FROM usuarios WHERE email = '$email'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc();

    // Verificar contraseña
    if (password_verify($contrasena, $row['contrasena'])) {
        $_SESSION['usuario'] = $usuario;
        echo "Bienvenido, $usuario. <a href='perfil.php'>Ir a tu perfil</a>";
    } else {
        echo "Contraseña incorrecta. <a href='login.html'>Volver</a>";
    }
} else {
    echo "El usuario no existe. <a href='registro.html'>Regístrate aquí</a>";
}

$conn->close();
?>

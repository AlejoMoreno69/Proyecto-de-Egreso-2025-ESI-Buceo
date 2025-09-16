<?php
session_start();

// Si no hay sesión activa, mandar al login
if (!isset($_SESSION['usuario'])) {
    header("Location: login.html");
    exit();
}

$servidor = "localhost";
$usuarioBD = "root";
$claveBD = "";
$baseDatos = "ejemplo_login";

$conn = new mysqli($servidor, $usuarioBD, $claveBD, $baseDatos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Buscar datos del usuario logueado
$usuario = $_SESSION['usuario'];
$sql = "SELECT * FROM usuarios WHERE usuario = '$usuario'";
$resultado = $conn->query($sql);

if ($resultado->num_rows > 0) {
    $row = $resultado->fetch_assoc(); // ✅ ahora sí existe $row
} else {
    echo "Usuario no encontrado.";
    exit();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil</title>
</head>
<body>
    <h1>Bienvenido, <?php echo $row['usuario']; ?></h1>
    <p>Tu foto de perfil:</p>
    <img src="<?php echo $row['foto_perfil']; ?>" alt="Foto de perfil" width="150"><br><br>
    <a href="logout.php">Cerrar Sesion Actual</a>
</body>
</html>

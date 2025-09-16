<?php
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
$cedula = $_POST['cedula'];
$telefono = $_POST['telefono'];

$rutaDestino = "uploads/" . basename($_FILES["foto"]["name"]);
move_uploaded_file($_FILES["foto"]["tmp_name"], $rutaDestino);

// Encriptar la contraseña
$contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

$tipoArchivo = strtolower(pathinfo($rutaDestino, PATHINFO_EXTENSION));
if($tipoArchivo != "jpg" && $tipoArchivo != "png" && $tipoArchivo != "jpeg") {
    die("Solo se permiten imágenes JPG, JPEG y PNG.");
}

$sql = "INSERT INTO usuarios (usuario, contrasena, email, cedula, telefono, foto_perfil) 
VALUES ('$usuario', '$contrasenaHash', '$email', '$cedula', '$telefono', '$rutaDestino')";

if ($conn->query($sql) === TRUE) {
    echo "Usuario registrado correctamente. <a href='login.html'>Inicia sesión aquí</a>";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
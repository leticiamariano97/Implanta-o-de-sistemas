<?php
declare(strict_types=1);

// Configuração LOCAL de demonstração do XAMPP.
// O usuário root sem senha é comum em instalações locais, mas não é recomendado em produção.
$host = '127.0.0.1';
$dbname = 'implantacao_sistema';
$username = 'root';
$password = '';

$dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Não foi possível conectar ao banco. Confira o XAMPP, o banco e o arquivo config.php.');
}

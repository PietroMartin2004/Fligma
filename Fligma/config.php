<?php
// FLIGMA/config.php

define('DB_HOST', 'localhost');
define('DB_NAME', 'fligma'); // Certifique-se que este é o nome do seu banco de dados
define('DB_USER', 'root');   // Seu usuário do MySQL/MariaDB
define('DB_PASS', '');       // Sua senha do MySQL/MariaDB (geralmente vazio no XAMPP)
define('DB_CHARSET', 'utf8mb4');

// A BASE_URL deve refletir o nome da sua pasta principal no htdocs.
// Se você acessa seu projeto como http://localhost/Fligma/, então '/Fligma' está correto.
// Se você está acessando diretamente via http://localhost/, use '/'.
define('BASE_URL', '/Fligma');
?>
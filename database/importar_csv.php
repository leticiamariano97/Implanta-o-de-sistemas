```php
<?php

// Obriga o PHP a trabalhar com declarações de tipos estritos.
// Isso ajuda a evitar conversões automáticas inesperadas de tipos.
declare(strict_types=1);

/*
IMPORTADOR DIDÁTICO DE CSV 
 Este programa lê um arquivo CSV contendo os dados dos sócios 
 e cadastra esses dados no banco de dados.

  Para executar, acesse pelo navegador:
  http://localhost/implantacao_sistema/database/importar_csv.php
 */

// Importa o arquivo de configuração do sistema.
// Nesse arquivo, espera-se que exista uma conexão PDO com o banco de dados.

// dirname(__DIR__) retorna o diretório pai da pasta atual.
require_once dirname(__DIR__) . '/config.php';


// Define o caminho do arquivo CSV que será importado.
$arquivo = dirname(__DIR__) . '/migracao/socios.csv';


// Verifica se o arquivo CSV realmente existe.
if (!is_file($arquivo)) {

    // Interrompe a execução e apresenta uma mensagem de erro caso o arquivo não seja encontrado.
    exit('Arquivo CSV não encontrado em migracao/socios.csv');
}


// Abre o arquivo CSV no modo de leitura.

// O parâmetro 'r' significa read (leitura).
// A variável $handle recebe a referência ao arquivo aberto.
$handle = fopen($arquivo, 'r');


// Verifica se o arquivo foi aberto corretamente.
if ($handle === false) {

    // Se fopen() falhar, interrompe o programa.
    exit('Não foi possível abrir o CSV.');
}


// Lê a primeira linha do arquivo CSV.

// Geralmente, a primeira linha contém os nomes das colunas
# Sistema de Sócios — Projeto didático PHP + XAMPP

Projeto para praticar instalação/configuração de um sistema e migração de dados.

## Requisitos
- XAMPP instalado.
- Apache e MySQL/MariaDB iniciados no XAMPP Control Panel.
- Navegador e, opcionalmente, Visual Studio Code.

## Instalação passo a passo
1. Copie a pasta 'implantacao_sistema' para 'C:\xampp\htdocs\'.
2. Abra o XAMPP Control Panel e inicie 'Apache' e 'MySQL'.
3. Acesse 'http://localhost/phpmyadmin/'.
4. No phpMyAdmin, abra a aba **Importar**.
5. Selecione o arquivo 'database/schema.sql' e execute a importação.
   - Alternativa: abra o arquivo, copie o SQL, cole na aba SQL do phpMyAdmin e execute.
6. Acesse 'http://localhost:8090/implantacao_sistema/'.
7. Cadastre um sócio de teste e confirme que ele aparece na tabela.
8. Faça a validação pelo phpMyAdmin
Abra o banco implantacao_sistema, clique na aba SQL e execute:
SELECT COUNT(*) AS total
FROM socios;

Para visualizar os registros:
SELECT *
FROM socios
ORDER BY id;

## Migração de dados CSV
1. Antes de importar, faça backup do banco pelo phpMyAdmin: selecione 'implantacao_sistema' > **Exportar** > método rápido > formato SQL > **Exportar**. Guarde o arquivo em local seguro.
2. O arquivo de origem está em 'migracao/socios.csv'. Ele contém apenas dados fictícios.
3. Acesse 'http://localhost/implantacao_sistema/database/importar_csv.php'.
4. Confira o resumo de inseridos/ignorados.
5. Volte ao sistema e confirme os registros.
6. No phpMyAdmin, selecione o banco, abra a aba SQL e execute:
   'SELECT COUNT(*) AS total FROM socios;'
7. Confira uma amostra:
   'SELECT * FROM socios ORDER BY id;'
8. Registre os resultados em 'documentacao/registro_instalacao.md'.

## Testar que o importador evita duplicações
Execute o importador uma segunda vez. Como ele verifica o e-mail existente, deverá ignorar os cinco e-mails do CSV que já foram importados. Compare os números apresentados.

## Estrutura do projeto
- 'index.php': formulário de cadastro e listagem.
- 'config.php': conexão PDO com o banco local.
- 'database/schema.sql': cria o banco e a tabela.
- 'migracao/socios.csv': dados fictícios de origem.
- 'database/importar_csv.php': importador didático com transação e validação básica.
- 'documentacao/registro_instalacao.md': checklist para os alunos.

## Notas de segurança
- Projeto exclusivamente para ambiente local de aula.
- O 'config.php' usa 'root' sem senha, padrão comum em instalações locais do XAMPP. Não use isso em produção.
- Não use dados pessoais reais.
- O importador CSV foi feito para demonstração local.
- Em uma implantação real, configure um usuário de banco com privilégios mínimos, proteja segredos, valide rigorosamente os dados, faça backups e teste a restauração.

<?php
declare(strict_types=1);
require_once __DIR__ . '/config.php';

$mensagem = '';
$tipoMensagem = 'sucesso';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $plano = trim($_POST['plano'] ?? '');

    if ($nome === '' || $email === '' || $plano === '') {
        $mensagem = 'Preencha todos os campos.';
        $tipoMensagem = 'erro';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensagem = 'Informe um e-mail válido.';
        $tipoMensagem = 'erro';
    } else {
        try {
            $stmt = $pdo->prepare(
                'INSERT INTO socios (nome, email, plano) VALUES (:nome, :email, :plano)'
            );
            $stmt->execute([
                ':nome' => $nome,
                ':email' => $email,
                ':plano' => $plano,
            ]);
            $mensagem = 'Sócio cadastrado com sucesso!';
        } catch (PDOException $e) {
            $mensagem = 'Não foi possível cadastrar. Verifique se o banco e a tabela foram criados.';
            $tipoMensagem = 'erro';
        }
    }
}

try {
    $socios = $pdo->query(
        'SELECT id, nome, email, plano, criado_em FROM socios ORDER BY id DESC'
    )->fetchAll();
} catch (PDOException $e) {
    $socios = [];
    $mensagem = 'Banco/tabela ainda não configurados. Siga o README para importar database/schema.sql.';
    $tipoMensagem = 'erro';
}
?>
<!doctype html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Sócios — Implantação</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; background: #f3f5f9; color: #202938; }
        header { background: #16324f; color: white; padding: 24px; }
        header .wrap, main { max-width: 1050px; margin: auto; }
        h1 { margin: 0 0 8px; }
        header p { margin: 0; color: #d8e4f0; }
        main { padding: 24px 16px 40px; }
        .grid { display: grid; grid-template-columns: 320px 1fr; gap: 20px; align-items: start; }
        .card { background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 12px #15223812; }
        label { display: block; margin: 14px 0 6px; font-weight: bold; }
        input, select { width: 100%; padding: 11px; border: 1px solid #cbd5e1; border-radius: 7px; font-size: 15px; }
        button { margin-top: 16px; border: 0; border-radius: 7px; padding: 12px 16px; background: #176b87; color: white; font-weight: bold; cursor: pointer; }
        button:hover { background: #10566d; }
        .msg { padding: 12px; border-radius: 7px; margin-bottom: 16px; background: #e4f7eb; }
        .msg.erro { background: #ffebeb; color: #8a1c1c; }
        .table-wrap { overflow-x: auto; }
        table { border-collapse: collapse; width: 100%; min-width: 600px; }
        th, td { text-align: left; padding: 11px; border-bottom: 1px solid #e5eaf0; }
        th { background: #f7f9fc; }
        .muted { color: #65748b; font-size: 14px; }
        footer { padding-top: 20px; color: #65748b; font-size: 13px; }
        @media (max-width: 760px) { .grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<header>
    <div class="wrap">
        <h1>Sistema de Sócios</h1>
        <p>Projeto didático para instalação, configuração e migração de dados.</p>
    </div>
</header>
<main>
    <?php if ($mensagem !== ''): ?>
        <div class="msg <?= $tipoMensagem === 'erro' ? 'erro' : '' ?>">
            <?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <div class="grid">
        <section class="card">
            <h2>Novo sócio</h2>
            <p class="muted">Cadastre dados fictícios para testar a aplicação.</p>
            <form method="post" action="">
                <label for="nome">Nome</label>
                <input id="nome" name="nome" required maxlength="120">

                <label for="email">E-mail</label>
                <input id="email" name="email" type="email" required maxlength="190">

                <label for="plano">Plano</label>
                <select id="plano" name="plano" required>
                    <option value="">Selecione</option>
                    <option>Básico</option>
                    <option>Premium</option>
                    <option>Familiar</option>
                </select>

                <button type="submit">Cadastrar sócio</button>
            </form>
        </section>

        <section class="card">
            <h2>Sócios cadastrados</h2>
            <p class="muted">A lista é carregada diretamente do banco de dados.</p>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>ID</th><th>Nome</th><th>E-mail</th><th>Plano</th><th>Criado em</th></tr></thead>
                    <tbody>
                    <?php if (!$socios): ?>
                        <tr><td colspan="5">Nenhum registro encontrado.</td></tr>
                    <?php else: ?>
                        <?php foreach ($socios as $socio): ?>
                            <tr>
                                <td><?= (int)$socio['id'] ?></td>
                                <td><?= htmlspecialchars($socio['nome'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($socio['email'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($socio['plano'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td><?= htmlspecialchars($socio['criado_em'], ENT_QUOTES, 'UTF-8') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    <footer>Ambiente didático local. Não utilize dados pessoais reais nem publique credenciais.</footer>
</main>
</body>
</html>

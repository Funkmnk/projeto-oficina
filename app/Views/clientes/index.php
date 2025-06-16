<?php

?>

<div class="card">
    <div class="card-header">
        <h1>Gerenciar Clientes</h1>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <a href="?page=clientes&action=create" class="btn btn-primary">
                    ➕ Novo Cliente
                </a>
            </div>
            <div class="col-md-6">
                <form method="GET" style="display: flex; gap: 0.5rem;">
                    <input type="hidden" name="page" value="clientes">
                    <input type="text" class="form-control" name="busca" 
                           placeholder="Buscar por nome, telefone, email ou CPF/CNPJ"
                           value="<?= htmlspecialchars($termo_busca) ?>">
                    <button type="submit" class="btn btn-secondary">Buscar</button>
                    <?php if (!empty($termo_busca)): ?>
                        <a href="?page=clientes" class="btn btn-warning">Limpar</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($mensagem)): ?>
    <div class="alert alert-success">
        <?= htmlspecialchars($mensagem) ?>
    </div>
<?php endif; ?>

<?php if (!empty($erro)): ?>
    <div class="alert alert-error">
        <?= htmlspecialchars($erro) ?>
    </div>
<?php endif; ?>

<?php if (!empty($termo_busca)): ?>
    <div class="alert alert-info">
        Resultados da busca por: <strong><?= htmlspecialchars($termo_busca) ?></strong>
        (<?= count($clientes) ?> resultado<?= count($clientes) != 1 ? 's' : '' ?> encontrado<?= count($clientes) != 1 ? 's' : '' ?>)
    </div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h2>Lista de Clientes (<?= count($clientes) ?> total)</h2>
    </div>
    <div class="card-body">
        <?php if (!empty($clientes)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Telefone</th>
                            <th>Email</th>
                            <th>CPF/CNPJ</th>
                            <th>Veículos</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($clientes as $cliente): ?>
                            <tr>
                                <td><?= $cliente['id'] ?></td>
                                <td>
                                    <strong><?= htmlspecialchars($cliente['nome']) ?></strong>
                                </td>
                                <td><?= htmlspecialchars($cliente['telefone']) ?></td>
                                <td>
                                    <?php if (!empty($cliente['email'])): ?>
                                        <a href="mailto:<?= htmlspecialchars($cliente['email']) ?>">
                                            <?= htmlspecialchars($cliente['email']) ?>
                                        </a>
                                    <?php else: ?>
                                        <span style="color: #6c757d;">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?= !empty($cliente['cpf_cnpj']) ? htmlspecialchars($cliente['cpf_cnpj']) : '<span style="color: #6c757d;">-</span>' ?>
                                </td>
                                <td>
                                    <span class="badge" style="background: #007bff; color: white; padding: 0.25rem 0.5rem; border-radius: 4px;">
                                        <?= $cliente['total_veiculos'] ?> veículo<?= $cliente['total_veiculos'] != 1 ? 's' : '' ?>
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; gap: 0.25rem; flex-wrap: wrap;">
                                        <a href="?page=clientes&action=view&id=<?= $cliente['id'] ?>" 
                                           class="btn btn-primary btn-sm" title="Ver detalhes">
                                            👁️
                                        </a>
                                        <a href="?page=clientes&action=edit&id=<?= $cliente['id'] ?>" 
                                           class="btn btn-warning btn-sm" title="Editar">
                                            ✏️
                                        </a>
                                        <a href="?page=clientes&action=delete&id=<?= $cliente['id'] ?>" 
                                           class="btn btn-danger btn-sm" title="Excluir"
                                           onclick="return confirm('Tem certeza que deseja excluir este cliente?')">
                                            🗑️
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div style="text-align: center; padding: 2rem;">
                <h3 style="color: #6c757d;">
                    <?php if (!empty($termo_busca)): ?>
                        Nenhum cliente encontrado para a busca
                    <?php else: ?>
                        Nenhum cliente cadastrado
                    <?php endif; ?>
                </h3>
                <p style="color: #6c757d;">
                    <?php if (!empty($termo_busca)): ?>
                        Tente buscar por outros termos ou <a href="?page=clientes">ver todos os clientes</a>.
                    <?php else: ?>
                        Comece cadastrando o primeiro cliente.
                    <?php endif; ?>
                </p>
                <a href="?page=clientes&action=create" class="btn btn-primary">
                    ➕ Cadastrar Cliente
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if (!empty($clientes)): ?>
    <div class="card">
        <div class="card-body" style="text-align: center;">
            <h4>Ações Rápidas</h4>
            <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap; margin-top: 1rem;">
                <a href="?page=clientes&action=create" class="btn btn-primary">
                    ➕ Novo Cliente
                </a>
                <a href="?page=veiculos&action=create" class="btn btn-success">
                    🚗 Cadastrar Veículo
                </a>
                <a href="?page=dashboard" class="btn btn-secondary">
                    📊 Voltar ao Dashboard
                </a>
            </div>
        </div>
    </div>
<?php endif; ?>
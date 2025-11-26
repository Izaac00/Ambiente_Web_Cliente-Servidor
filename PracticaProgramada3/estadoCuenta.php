<?php
session_start();
include 'header.php';

if (!isset($_SESSION['transacciones'])) {
    $_SESSION['transacciones'] = [];
}

function registrarTransaccion($id, $descripcion, $monto) {
    $_SESSION['transacciones'][] = [
        'id' => $id,
        'descripcion' => $descripcion,
        'monto' => $monto
    ];
}

function generarEstadoDeCuenta() {
    $lista = $_SESSION['transacciones'];
    $totalContado = 0;

    foreach ($lista as $t) {
        $totalContado += $t['monto'];
    }

    $interes = $totalContado * 0.026;
    $totalConInteres = $totalContado + $interes;
    $cashback = $totalContado * 0.001;
    $montoFinal = $totalConInteres - $cashback;

    $contenido = "ESTADO DE CUENTA\n\n";
    $contenido .= "TRANSACCIONES:\n";

    foreach ($lista as $t) {
        $contenido .= "ID: {$t['id']} - {$t['descripcion']} - Monto: $" . number_format($t['monto'], 2) . "\n";
    }

    $contenido .= "\nTOTAL DE CONTADO: $" . number_format($totalContado, 2) . "\n";
    $contenido .= "TOTAL CON INTERÉS (2.6%): $" . number_format($totalConInteres, 2) . "\n";
    $contenido .= "CASHBACK (0.1%): $" . number_format($cashback, 2) . "\n";
    $contenido .= "MONTO FINAL A PAGAR: $" . number_format($montoFinal, 2) . "\n";

    file_put_contents("estado_cuenta.txt", $contenido);

    return [
        'totalContado' => $totalContado,
        'interes' => $interes,
        'totalConInteres' => $totalConInteres,
        'cashback' => $cashback,
        'montoFinal' => $montoFinal
    ];
}

if (isset($_POST['registrar'])) {
    registrarTransaccion($_POST['id'], $_POST['descripcion'], floatval($_POST['monto']));
}

$estado = null;
if (isset($_POST['generar'])) {
    $estado = generarEstadoDeCuenta();
}
?>

<h3 class="mb-4">Registrar Transacciones</h3>

<div class="card p-4 mb-4 shadow-sm">
    <form method="post">
        <div class="mb-3">
            <label class="form-label">ID</label>
            <input type="number" name="id" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <input type="text" name="descripcion" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Monto</label>
            <input type="number" step="0.01" name="monto" class="form-control" required>
        </div>

        <button name="registrar" class="btn btn-primary w-100">Registrar Transacción</button>
    </form>
</div>

<h4 class="mb-3">Transacciones Registradas</h4>

<ul class="list-group mb-4">
<?php if (count($_SESSION['transacciones']) == 0): ?>
    <li class="list-group-item">No hay transacciones registradas.</li>
<?php else: ?>
    <?php foreach ($_SESSION['transacciones'] as $t): ?>
        <li class="list-group-item">
            <strong>ID:</strong> <?= $t['id'] ?> |
            <strong>Descripción:</strong> <?= $t['descripcion'] ?> |
            <strong>Monto:</strong> $<?= number_format($t['monto'], 2) ?>
        </li>
    <?php endforeach; ?>
<?php endif; ?>
</ul>

<form method="post">
    <button name="generar" class="btn btn-success w-100 mb-4">Generar Estado de Cuenta</button>
</form>

<?php if ($estado): ?>
<div class="card p-3 shadow-sm">
    <h4>Estado de Cuenta</h4>

    <p><strong>Total de contado:</strong> $<?= number_format($estado['totalContado'], 2) ?></p>
    <p><strong>Interés (2.6%):</strong> $<?= number_format($estado['interes'], 2) ?></p>
    <p><strong>Total con interés:</strong> $<?= number_format($estado['totalConInteres'], 2) ?></p>
    <p><strong>Cashback (0.1%):</strong> $<?= number_format($estado['cashback'], 2) ?></p>
    <p><strong>Monto final a pagar:</strong> $<?= number_format($estado['montoFinal'], 2) ?></p>

    <p class="text-success mt-3">Archivo <strong>estado_cuenta.txt</strong> generado.</p>
</div>
<?php endif; ?>

<?php include 'footer.php'; ?>
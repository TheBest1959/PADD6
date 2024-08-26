<?php
// Iniciar la sesión
session_start();

// Incluir archivos necesarios
require_once 'querys/qsoportes.php';
require_once 'componentes/header.php';
require_once 'componentes/sidebar.php';

// Función para escapar la salida HTML
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>

<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Listado de Soportes</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="tableExportadora">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre Soporte</th>
                                            <th>Nombre de Proveedor</th>
                                            <th>RUT</th>
                                            <th>Teléfono Fijo</th>
                                            <th>Teléfono Móvil</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($soportes as $soporte): ?>
                                            <?php $proveedor = $proveedoresMap[$soporte['id_proveedor']] ?? []; ?>
                                            <tr>
                                                <td><?= e($soporte['id_soporte']) ?></td>
                                                <td><?= e($soporte['nombreIdentficiador']) ?></td>
                                                <td><?= e($proveedor['nombreProveedor'] ?? '') ?></td>
                                                <td><?= e($proveedor['rutProveedor'] ?? '') ?></td>
                                                <td><?= e($proveedor['telFijo'] ?? '') ?></td>
                                                <td><?= e($proveedor['telCelular'] ?? '') ?></td>
                                                <td>
                                                    <div class="alineado">
                                                        <label class="custom-switch sino" data-toggle="tooltip"
                                                            title="<?= $soporte['estado'] ? 'Desactivar Soporte' : 'Activar Cliente' ?>">
                                                            <input type="checkbox"
                                                                class="custom-switch-input estado-soporte"
                                                                data-id="<?= e($soporte['id_soporte'] ?? '') ?>" 
                                                                data-tipo="proveedor" 
                                                                <?= isset($soporte['estado']) && $soporte['estado'] ? 'checked' : '' ?>>
                                                            <span class="custom-switch-indicator"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary micono" href="views/viewSoportes.php?id_soporte=<?= e($soporte['id_soporte']) ?>" data-toggle="tooltip" title="Ver Soporte">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a class="btn btn-success micono" data-bs-toggle="modal" data-bs-target="#actualizar_soportes" data-id-soporte="<?= e($soporte['id_soporte']) ?>" onclick="obtenerDatos(<?= e($soporte['id_soporte']) ?>)">
                                                        <i class="fas fa-pencil-alt"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script src="assets/js/toggleSoportes.js"></script>

<script src="assets/js/actualizar_soportes.js"></script>

<!-- <script src="assets/js/getmedios.js"></script> -->


<?php 
require_once 'views/modalUpdateSoportes.php';
require_once 'componentes/settings.php';
require_once 'componentes/footer.php';
?>
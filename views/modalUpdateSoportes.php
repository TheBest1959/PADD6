<div class="modal fade" id="actualizar_soportes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Actualizar Soporte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>

                <form id="formularioactualizarSoporteProv">
                    <!-- Campos del formulario -->
                    <div class="mb-4">
                        <h3 class="titulo-registro mb-3">Datos del Soporte</h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nombreIdentficiador">Nombre Identificador</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-tag"></i></span>
                                    <input type="hidden" name="id_soporte" id="id_soporte" value="">
                                    <input type="hidden" name="id_proveedor">
                                    <input type="hidden" name="rutProveedorx">
                                    <input class="form-control" placeholder="Nombre Identificador" name="nombreIdentficiador">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nombreRepresentante">Nombre Representante</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                                    <input class="form-control" placeholder="Nombre Representante" name="nombreRepresentante">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="rutSoporte" class="form-label">Rut Soporte</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" class="form-control" placeholder="Rut Soporte" id="rutSoporte" name="rutSoporte" required>
                                </div>
                                <div class="custom-tooltip" id="rutSoporte-tooltip"></div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="giroProveedorx">Giro Soporte</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                    <input class="form-control" placeholder="Giro Proveedor" name="giroProveedorx">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="nombreFantasia">Nombre de Fantasía</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-shop"></i></span>
                                    <input class="form-control" placeholder="Nombre de Fantasía" name="nombreFantasia">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="rutRepresentantex" class="form-label">Rut Representante</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                                    <input type="text" class="form-control" placeholder="Rut Representante" id="rutRepresentantex" name="rutRepresentantex" required>
                                </div>
                                <div class="custom-tooltip" id="rutRepresentantex-tooltip"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label" for="codigo">Medios</label>
                                <div class="medio-soporte"></div>
                                <label class="form-label" for="codigo">Seleccionar medios</label>
                                <div id="select-medios"></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <h3 class="titulo-registro mb-3">Datos de facturación</h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="razonSocialx" class="form-label">Razón Social</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-building"></i></span>
                                    <input class="form-control" placeholder="Razón Social" name="razonSocialx">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="direccionx" class="form-label">Dirección Facturación</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                    <input class="form-control" placeholder="Dirección Facturación" name="direccionx">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="regionx">Región</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-map"></i></span>
                                    <select class="sesel form-select" name="id_regionx" id="regionx" required>
                                        <?php foreach ($regiones as $regione) : ?>
                                            <option value="<?php echo $regione['id']; ?>"><?php echo $regione['nombreRegion']; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" for="comunax">Comuna</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-pin-map"></i></span>
                                    <select class="sesel form-select" name="id_comunax" id="comunax" required>
                                        <?php foreach ($comunas as $comuna) : ?>
                                            <option value="<?php echo $comuna['id_comuna']; ?>" data-region="<?php echo $comuna['id_region']; ?>">
                                                <?php echo $comuna['nombreComuna']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="telCelularx" class="form-label">Teléfono celular</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="text" class="phone-input form-control" placeholder="Teléfono celular" id="telCelularx" name="telCelularx" required>
                                </div>
                                <div class="custom-tooltip" id="telCelularx-tooltip"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="telFijox" class="form-label">Teléfono Fijo</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                    <input type="text" class="phone-input form-control" placeholder="Teléfono fijo" id="telFijox" name="telFijox" required>
                                </div>
                                <div class="custom-tooltip" id="telFijox-tooltip"></div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="emailx" class="form-label">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="text" class="form-control email-input" placeholder="Email" id="emailx" name="emailx" required>
                                </div>
                                <div class="custom-tooltip" id="emailx-tooltip"></div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="titulo-registro mb-3">Otros datos</h3>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="bonificacion_anox" class="form-label">Bonificación por año %</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-percent"></i></span>
                                    <input class="form-control" placeholder="Bonificación por año %" name="bonificacion_anox">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3" id="moneda-container">
                                <label for="escala_rangox" class="form-label">Escala de rango</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-bar-chart-line"></i></span>
                                    <input class="form-control" placeholder="Escala de rango" name="escala_rangox">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="micono btn btn-primary" type="submit" id="actualizarSoporte">
                            <span class="btn-txt">Actualizar Soporte</span>
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true" style="display:none;"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .medio-soporte {
        margin: 30px 0px;
    }

    .medio-soporte .medio-item {
        border-radius: 30px;
        padding: 5px 10px;
        border: solid;
    }
</style>

<div class="modal fade" id="actualizar_soportes" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <!-- Alerta para mostrar el resultado de la actualización -->
                <div id="updateAlert" class="alert" style="display:none;" role="alert"></div>

                <form id="formularioactualizarSoporteProv">
                    <!-- Campos del formulario -->
                    <div>
                        <h3 class="titulo-registro mb-3">Actualizar Soporte</h3>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="labelforms" for="codigo">Nombre Identificador</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                                        </div>
                                        <input type="hidden" name="id_soporte" id="id_soporte" value="">
                                        <input type="hidden" name="id_proveedor">
                                        <input type="hidden" name="rutProveedorx">
                                        <input class="form-control" placeholder="Nombre Identificador" name="nombreIdentficiador">
                                    </div>

                                    <label class="labelforms" for="codigo">Nombre Representante</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-person-circle"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre Representante" name="nombreRepresentante">
                                    </div>
                                    <label class="labelforms" for="codigo">Medios</label>
                                    <div class="medio-soporte"></div>
                                    <label class="labelforms" for="codigo">Seleccionar medios</label>
                                    <div id="select-medios"></div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">

                                    <label for="rutSoporte" class="labelforms">Rut Soporte</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
                                        <input type="text" class="form-control" placeholder="Rut Soporte" id="rutSoporte" name="rutSoporte" required>
                                        <div class="custom-tooltip" id="rutSoporte-tooltip"></div>
                                    </div>

                                    <label class="labelforms" for="codigo">Giro Soporte</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Giro Proveedor" name="giroProveedorx">
                                    </div>
                                    <label class="labelforms" for="codigo">Nombre de Fantasía</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-hand-thumbs-up"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Nombre de Fantasía" name="nombreFantasia">
                                    </div>

                                    <label for="rutRepresentantex" class="labelforms">Rut Representante</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-credit-card-2-front"></i></span>
                                        <input type="text" class="form-control" placeholder="Rut Representante" id="rutRepresentantex" name="rutRepresentantex" required>
                                        <div class="custom-tooltip" id="rutRepresentantex-tooltip"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h3 class="titulo-registro mb-3">Datos de facturación</h3>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="codigo">Razón Social</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-bullseye"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Razón Social" name="razonSocialx">
                                    </div>
                                    <label class="labelforms" for="codigo">Región</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                        </div>
                                        <select class="sesel form-select" name="id_regionx" id="regionx" required>
                                            <?php foreach ($regiones as $regione) : ?>
                                                <option value="<?php echo $regione['id']; ?>"><?php echo $regione['nombreRegion']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <label for="telCelularx" class="labelforms">Teléfono celular</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" class="phone-input form-control" placeholder="Teléfono celular" id="telCelularx" name="telCelularx" required>
                                        <div class="custom-tooltip" id="telCelularx-tooltip"></div>
                                    </div>

                                    <label for="emailx" class="labelforms">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                        <input type="text" class="form-control email-input" placeholder="Email" id="emailx" name="emailx" required>
                                        <div class="custom-tooltip" id="emailx-tooltip"></div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="codigo">Dirección Facturación</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-building"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Dirección Facturación" name="direccionx">
                                    </div>
                                    <label class="labelforms" for="codigo">Comuna</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-geo-alt"></i></span>
                                        </div>
                                        <select class="sesel form-select" name="id_comunax" id="comunax" required>
                                            <?php foreach ($comunas as $comuna) : ?>
                                                <option value="<?php echo $comuna['id_comuna']; ?>" data-region="<?php echo $comuna['id_region']; ?>">
                                                    <?php echo $comuna['nombreComuna']; ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <label for="telFijox" class="labelforms">Teléfono Fijo</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="bi bi-telephone"></i></span>
                                        <input type="text" class="phone-input form-control" placeholder="Teléfono fijo" id="telFijox" name="telFijox" required>
                                        <div class="custom-tooltip" id="telFijox-tooltip"></div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <h3 class="titulo-registro mb-3">Otros datos</h3>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="codigo">Bonificación por año %</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-currency-dollar"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Bonificación por año %" name="bonificacion_anox">
                                    </div>
                                </div>
                            </div>
                            <div class="col" id="moneda-container">
                                <div class="form-group">
                                    <label for="codigo">Escala de rango</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="bi bi-bar-chart-line"></i></span>
                                        </div>
                                        <input class="form-control" placeholder="Escala de rango" name="escala_rangox">
                                    </div>
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

<?php
// Iniciar la sesión
session_start();

// Incluir funciones necesarias
include '../querys/qclientes.php';

// Obtener el ID del cliente de la URL
$idCliente = isset($_GET['id_cliente']) ? $_GET['id_cliente'] : null;

if (!$idCliente) {
    die("No se proporcionó un ID de cliente válido.");
}

// Obtener datos del cliente específico
$url = "https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes?id_cliente=eq.$idCliente&select=*";
$cliente = makeRequest($url);

// Verificar si se obtuvo el cliente
if (empty($cliente) || !isset($cliente[0])) {
    die("No se encontró el cliente con el ID proporcionado.");
}

$datosCliente = $cliente[0];

// Obtener productos asociados al cliente
$productos = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Productos?Id_Cliente=eq.$idCliente&select=*");

// Crear un mapa de productos para fácil acceso si es necesario
$productosMap = array_column($productos, null, 'id');

// Obtener comisión del cliente
$comisionCliente = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones?id_cliente=eq.$idCliente&select=*");

// Verificar si se obtuvo la comisión del cliente
if (!empty($comisionCliente) && is_array($comisionCliente) && isset($comisionCliente[0])) {
    $primerComision = $comisionCliente[0];
    
    $valorComision = $primerComision['valorComision'] ?? "No disponible";
    $fechaInicio = $primerComision['inicioComision'] ?? "No disponible";
    $fechaTermino = $primerComision['finComision'] ?? "No disponible";
} else {
    $valorComision = "No disponible";
    $fechaInicio = "No disponible";
    $fechaTermino = "No disponible";
}

// Obtener tipos de moneda
$monedas = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/TipoMoneda?select=*");

// Crear un mapa de monedas para fácil acceso
$monedasMap = array_column($monedas, 'nombreMoneda', 'id_moneda');

// Obtener tipos de formato
$formatos = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/formatoComision?select=*");
// Crear un mapa de formatos para fácil acceso
$formatosMap = array_column($formatos, 'nombreFormato', 'id_formatoComision');

// Obtener tipos de cliente
$tiposCliente = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/TipoCliente?select=*");
$tiposClienteMap = array_column($tiposCliente, 'nombreTipoCliente', 'id_tyipoCliente');

// Obtener regiones y comunas
$regiones = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Region?select=*");
$comunas = makeRequest("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comuna?select=*");
$regionesMap = array_column($regiones, 'nombreRegion', 'id');
$comunasMap = array_column($comunas, 'nombreComuna', 'id_comuna');

include '../componentes/header.php';
include '../componentes/sidebar.php';
?>
<!-- Main Content -->
<div class="main-content">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>dashboard.php">Home</a></li>
            <li class="breadcrumb-item"><a href="<?php echo $ruta; ?>ListClientes.php">Ver Clientes</a></li>
            <li class="breadcrumb-item active" aria-current="page"><?php echo $datosCliente['nombreCliente']; ?></li>
        </ol>
    </nav>
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                <div class="clearfix"></div>
                                <div class="nombrex author-box-name">
                                    <?php echo $datosCliente['nombreCliente']; ?>
                                </div>
                                <div class="author-box-job">
                                    <?php
                                    $fecha = new DateTime($datosCliente['created_at']);
                                    echo 'Registrado el: '.$fecha->format('d-m-Y');
                                    ?>
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="author-box-job">
                                    <?php echo 'Representante Legal: ' . $datosCliente['nombreRepresentanteLegal']; ?>
                                </div>
                                <div class="w-100 d-sm-none"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <div class="cabeza">
                                <h4>Detalles del Cliente</h4> 
                                <button type="button" class="btn btn-success micono" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#actualizarclienteView" 
                                    data-idcliente="<?php echo $datosCliente['id_cliente']; ?>">
                                    <i class="fas fa-pencil-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="py-4">
                                <!-- Aquí van los detalles del cliente -->
                                <!-- ... (el resto del código HTML para mostrar los detalles del cliente) ... -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="padding-20">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <!-- ... (pestañas de navegación) ... -->
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <!-- ... (contenido de las pestañas) ... -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal para Actualizar Cliente -->
<div class="modal fade" id="actualizarclienteView" tabindex="-1" aria-labelledby="actualizarclienteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="actualizarclienteLabel">Actualizar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateClienteForm">
                    <input type="hidden" id="id_cliente" name="id_cliente">
                    <!-- ... (campos del formulario) ... -->
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="updateClienteBtn">Actualizar Cliente</button>
            </div>
        </div>
    </div>
</div>

<script>
// Definimos loadClienteData en el ámbito global
window.loadClienteData = function(id_cliente) {
    console.log('Función loadClienteData llamada con ID:', id_cliente);

    const SUPABASE_API_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc';

    fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes?id_cliente=eq.${id_cliente}&select=*`, {
        headers: {
            'apikey': SUPABASE_API_KEY,
            'Authorization': `Bearer ${SUPABASE_API_KEY}`
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('HTTP error ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data && data.length > 0) {
            const cliente = data[0];
            console.log('Datos del cliente recibidos:', cliente);
            
            // Llenar los campos del formulario
            document.getElementById('id_cliente').value = cliente.id_cliente;
            document.getElementById('update_nombreCliente').value = cliente.nombreCliente;
            document.getElementById('update_nombreFantasia').value = cliente.nombreFantasia;
            document.getElementById('update_id_tipoCliente').value = cliente.id_tipoCliente;
            document.getElementById('update_razonSocial').value = cliente.razonSocial;
            document.getElementById('update_grupo').value = cliente.grupo;
            document.getElementById('update_RUT').value = cliente.RUT;
            document.getElementById('update_giro').value = cliente.giro;
            document.getElementById('update_nombreRepresentanteLegal').value = cliente.nombreRepresentanteLegal;
            document.getElementById('update_Rut_representante').value = cliente.RUT_representante;
            document.getElementById('update_direccionEmpresa').value = cliente.direccionEmpresa;
            document.getElementById('update_id_region').value = cliente.id_region;
            document.getElementById('update_telCelular').value = cliente.telCelular;
            document.getElementById('update_telFijo').value = cliente.telFijo;
            document.getElementById('update_email').value = cliente.email;
            
            // Actualizar las comunas basadas en la región seleccionada
            const regionSelect = document.getElementById('update_id_region');
            if (regionSelect) {
                regionSelect.dispatchEvent(new Event('change'));
            
                // Esperar un momento para que las comunas se actualicen y luego seleccionar la comuna correcta
                setTimeout(() => {
                    document.getElementById('update_id_comuna').value = cliente.id_comuna;
                }, 100);
            }

            console.log('Datos del cliente cargados correctamente en el formulario');
        } else {
            throw new Error('No se encontraron datos del cliente');
        }
    })
    .catch(error => {
        console.error('Error en loadClienteData:', error);
        Swal.fire({
            title: 'Error',
            text: 'Hubo un problema al cargar los datos del cliente: ' + error.message,
            icon: 'error',
            confirmButtonText: 'OK'
        });
    });
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM completamente cargado y analizado');

    function updateCliente(formData) {
        console.log('Función updateCliente llamada');

        const SUPABASE_API_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc';

        fetch('https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Clientes', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'apikey': SUPABASE_API_KEY,
                'Authorization': `Bearer ${SUPABASE_API_KEY}`,
                'Prefer': 'return=minimal'
            },
            body: JSON.stringify(Object.fromEntries(formData))
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('HTTP error ' + response.status);
            }
            return response.json();
        })
        .then(data => {
            Swal.fire({
                title: 'Éxito',
                text: 'Cliente actualizado correctamente',
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
            });
        })
        .catch(error => {
            console.error('Error al actualizar cliente:', error);
            Swal.fire({
                title: 'Error',
                text: 'Hubo un problema al actualizar el cliente: ' + error.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }

    // Agregar evento de clic al botón que abre el modal
    const updateButton = document.querySelector('[data-bs-target="#actualizarclienteView"]');
    if (updateButton) {
        console.log('Botón de actualización encontrado');
        updateButton.addEventListener('click', function() {
            console.log('Clic en el botón de actualización');
            const id_cliente = this.getAttribute('data-idcliente');
            console.log('ID del cliente obtenido:', id_cliente);
            loadClienteData(id_cliente);
        });
    } else {
        console.error('Botón de actualización no encontrado');
    }

    // Evento para el botón de actualizar cliente dentro del modal
    const updateClienteBtn = document.getElementById('updateClienteBtn');
    if (updateClienteBtn) {
        console.log('Botón updateClienteBtn encontrado');
        updateClienteBtn.addEventListener('click', function() {
            console.log('Clic en el botón de actualizar cliente');
            const form = document.getElementById('updateClienteForm');
            const formData = new FormData(form);
            updateCliente(formData);
        });
    } else {
        console.error('Botón updateClienteBtn no encontrado');
    }

    // Manejar cambios en la región para actualizar las comunas
    const regionSelect = document.getElementById('update_id_region');
    if (regionSelect) {
        regionSelect.addEventListener('change', function() {
            const selectedRegion = this.value;
            const comunaSelect = document.getElementById('update_id_comuna');
            
            // Ocultar todas las opciones de comuna
            Array.from(comunaSelect.options).forEach(option => {
                option.style.display = option.dataset.region === selectedRegion ? '' : 'none';
            });

            // Seleccionar la primera comuna visible
            const firstVisibleOption = Array.from(comunaSelect.options).find(option => option.style.display !== 'none');
            if (firstVisibleOption) {
                firstVisibleOption.selected = true;
            }
        });
    }
});
</script>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const SUPABASE_API_KEY = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc';
    const idCliente = document.querySelector('input[name="id_cliente"]').value;

    async function cargarYMostrarComisiones() {
        try {
            const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones?id_cliente=eq.${idCliente}&select=*`, {
                headers: {
                    'apikey': SUPABASE_API_KEY,
                    'Authorization': `Bearer ${SUPABASE_API_KEY}`
                }
            });
            
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            
            const comisiones = await response.json();
            actualizarTablaComisiones(comisiones);
        } catch (error) {
            console.error('Error al cargar comisiones:', error);
            mostrarError('Error al cargar las comisiones: ' + error.message);
        }
    }

    function actualizarTablaComisiones(comisiones) {
        const tbody = document.querySelector('#otros table tbody');
        if (!tbody) {
            console.error('No se encontró el tbody de la tabla');
            return;
        }

        tbody.innerHTML = '';

        if (comisiones.length === 0) {
            tbody.innerHTML = '<tr><td colspan="6">No hay comisiones disponibles</td></tr>';
            return;
        }

        comisiones.forEach(comision => {
            const row = tbody.insertRow();
            row.innerHTML = `
                <td>${obtenerNombreMoneda(comision.id_tipoMoneda)}</td>
                <td>${comision.valorComision}</td>
                <td>${obtenerNombreFormato(comision.id_formatoComision)}</td>
                <td>${comision.inicioComision}</td>
                <td>${comision.finComision}</td>
                <td>
                    <button class="btn btn-success micono editar-comision" data-id="${comision.id_comision}">
                        <i class="fas fa-pencil-alt"></i>
                    </button>
                    <button class="btn btn-danger micono eliminar-comision" data-id="${comision.id_comision}">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>
            `;
        });

        agregarEventListeners();
    }

    function agregarEventListeners() {
        document.querySelectorAll('.editar-comision').forEach(btn => {
            btn.onclick = (e) => cargarDatosComision(e.currentTarget.dataset.id);
        });
        document.querySelectorAll('.eliminar-comision').forEach(btn => {
            btn.onclick = (e) => eliminarComision(e.currentTarget.dataset.id);
        });
    }

    async function cargarDatosComision(id) {
        try {
            const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones?id_comision=eq.${id}`, {
                headers: {
                    'apikey': SUPABASE_API_KEY,
                    'Authorization': `Bearer ${SUPABASE_API_KEY}`
                }
            });
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            const [comision] = await response.json();
            
            if (comision) {
                document.getElementById('actualizar_id_comision').value = comision.id_comision;
                document.getElementById('actualizar_nombreMoneda').value = comision.id_tipoMoneda;
                document.getElementById('actualizar_valorComision').value = comision.valorComision;
                document.getElementById('actualizar_nombreFormato').value = comision.id_formatoComision;
                document.getElementById('actualizar_inicioComision').value = comision.inicioComision;
                document.getElementById('actualizar_finComision').value = comision.finComision;

                new bootstrap.Modal(document.getElementById('actualizarcomisionModal')).show();
            }
        } catch (error) {
            console.error('Error al cargar los datos de la comisión:', error);
            mostrarError('No se pudieron cargar los datos de la comisión');
        }
    }

    async function actualizarComision(event) {
        event.preventDefault();
        const formData = new FormData(event.target);
        const id = formData.get('id_comision');
        const data = {
            id_cliente: parseInt(idCliente),
            id_tipoMoneda: parseInt(formData.get('nombreMoneda')),
            id_formatoComision: parseInt(formData.get('nombreFormato')),
            valorComision: parseFloat(formData.get('valorComision')),
            inicioComision: formData.get('inicioComision'),
            finComision: formData.get('finComision')
        };

        try {
            const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones?id_comision=eq.${id}`, {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'apikey': SUPABASE_API_KEY,
                    'Authorization': `Bearer ${SUPABASE_API_KEY}`,
                    'Prefer': 'return=minimal'
                },
                body: JSON.stringify(data)
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            mostrarExito('Comisión actualizada correctamente');
            bootstrap.Modal.getInstance(document.getElementById('actualizarcomisionModal')).hide();
            await cargarYMostrarComisiones();
        } catch (error) {
            console.error('Error al actualizar la comisión:', error);
            mostrarError('No se pudo actualizar la comisión: ' + error.message);
        }
    }

    async function eliminarComision(id) {
        if (!await confirmarEliminar()) return;

        try {
            const response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Comisiones?id_comision=eq.${id}`, {
                method: 'DELETE',
                headers: {
                    'apikey': SUPABASE_API_KEY,
                    'Authorization': `Bearer ${SUPABASE_API_KEY}`
                }
            });

            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);

            mostrarExito('La comisión ha sido eliminada.');
            await cargarYMostrarComisiones();
        } catch (error) {
            console.error('Error al eliminar la comisión:', error);
            mostrarError('No se pudo eliminar la comisión: ' + error.message);
        }
    }

    function obtenerNombreMoneda(id) {
        const monedas = <?php echo json_encode($monedasMap); ?>;
        return monedas[id] || 'Desconocido';
    }

    function obtenerNombreFormato(id) {
        const formatos = <?php echo json_encode($formatosMap); ?>;
        return formatos[id] || 'Desconocido';
    }

    function mostrarExito(mensaje) {
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: mensaje,
            showConfirmButton: false,
            timer: 1500
        });
    }

    function mostrarError(mensaje) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: mensaje
        });
    }

    async function confirmarEliminar() {
        const result = await Swal.fire({
            title: '¿Estás seguro?',
            text: "No podrás revertir esta acción!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminar!',
            cancelButtonText: 'Cancelar'
        });
        return result.isConfirmed;
    }

    // Event Listeners
    document.getElementById('actualizarComisionForm').addEventListener('submit', actualizarComision);
    document.getElementById('updateMedioForm3').addEventListener('submit', agregarComision);

    // Inicialización
    cargarYMostrarComisiones();
});
</script>

<script src="../assets/js/deleteComision.js"></script>
<script src="../assets/js/deleteProducto.js"></script>
<?php include '../componentes/settings.php'; ?>
<?php include '../componentes/footer.php'; ?>
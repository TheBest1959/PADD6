<?php
// Habilitar reporte de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Establecer el tipo de contenido de la respuesta
header('Content-Type: application/json');

// Configuración de Supabase
$supabaseUrl = 'https://ekyjxzjwhxotpdfzcpfq.supabase.co';
$supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc';

// Función para sanitizar entradas
function sanitize_input($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

// Verificar si se recibieron los datos del cliente
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener y sanitizar los datos del cliente
    $id_cliente = filter_input(INPUT_POST, 'id_cliente', FILTER_SANITIZE_NUMBER_INT);
    $nombreCliente = sanitize_input($_POST['nombreCliente'] ?? '');
    $nombreFantasia = sanitize_input($_POST['nombreFantasia'] ?? '');
    $id_tipoCliente = filter_input(INPUT_POST, 'id_tipoCliente', FILTER_SANITIZE_NUMBER_INT);
    $razonSocial = sanitize_input($_POST['razonSocial'] ?? '');
    $grupo = sanitize_input($_POST['grupo'] ?? '');
    $RUT = sanitize_input($_POST['RUT'] ?? '');
    $giro = sanitize_input($_POST['giro'] ?? '');
    $nombreRepresentanteLegal = sanitize_input($_POST['nombreRepresentanteLegal'] ?? '');
    $RUT_representante = sanitize_input($_POST['RUT_representante'] ?? '');
    $direccionEmpresa = sanitize_input($_POST['direccionEmpresa'] ?? '');
    $id_region = filter_input(INPUT_POST, 'id_region', FILTER_SANITIZE_NUMBER_INT);
    $id_comuna = filter_input(INPUT_POST, 'id_comuna', FILTER_SANITIZE_NUMBER_INT);
    $telCelular = sanitize_input($_POST['telCelular'] ?? '');
    $telFijo = sanitize_input($_POST['telFijo'] ?? '');
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $formato = sanitize_input($_POST['formato'] ?? '');
    $nombreMoneda = sanitize_input($_POST['nombreMoneda'] ?? '');
    $valor = filter_input(INPUT_POST, 'valor', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

    // Verificar que el id_cliente no esté vacío
    if (empty($id_cliente)) {
        echo json_encode([
            'success' => false,
            'error' => 'ID de cliente no proporcionado',
            'alert' => [
                'title' => 'Error',
                'text' => 'ID de cliente no proporcionado',
                'icon' => 'error'
            ]
        ]);
        exit;
    }

    // Preparar los datos para la actualización
    $data = [
        'nombreCliente' => $nombreCliente,
        'nombreFantasia' => $nombreFantasia,
        'id_tipoCliente' => $id_tipoCliente,
        'razonSocial' => $razonSocial,
        'grupo' => $grupo,
        'RUT' => $RUT,
        'giro' => $giro,
        'nombreRepresentanteLegal' => $nombreRepresentanteLegal,
        'RUT_representante' => $RUT_representante,
        'direccionEmpresa' => $direccionEmpresa,
        'id_region' => $id_region,
        'id_comuna' => $id_comuna,
        'telCelular' => $telCelular,
        'telFijo' => $telFijo,
        'email' => $email,
        'formato' => $formato,
        'nombreMoneda' => $nombreMoneda,
        'valor' => $valor
    ];

    // Eliminar campos vacíos
    $data = array_filter($data, function($value) {
        return $value !== null && $value !== '';
    });

    // Inicializar cURL
    $ch = curl_init();

    // Configurar la solicitud cURL
    curl_setopt($ch, CURLOPT_URL, $supabaseUrl . '/rest/v1/Clientes?id_cliente=eq.' . $id_cliente);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'apikey: ' . $supabaseKey,
        'Authorization: Bearer ' . $supabaseKey,
        'Content-Type: application/json',
        'Prefer: return=minimal'
    ]);

    // Ejecutar la solicitud
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    // Verificar si hubo un error de cURL
    if(curl_errno($ch)){
        echo json_encode([
            'success' => false,
            'error' => 'Error de cURL: ' . curl_error($ch),
            'alert' => [
                'title' => 'Error',
                'text' => 'Error de conexión: ' . curl_error($ch),
                'icon' => 'error'
            ]
        ]);
        curl_close($ch);
        exit;
    }

    // Cerrar cURL
    curl_close($ch);

    // Verificar la respuesta
    if ($httpCode == 204) {
        echo json_encode([
            'success' => true,
            'message' => 'Cliente actualizado correctamente',
            'alert' => [
                'title' => '¡Éxito!',
                'text' => 'Cliente actualizado correctamente',
                'icon' => 'success'
            ]
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'error' => 'Error al actualizar el cliente. Código HTTP: ' . $httpCode,
            'response' => $response,
            'alert' => [
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar el cliente. Código HTTP: ' . $httpCode,
                'icon' => 'error'
            ]
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Método de solicitud no válido',
        'alert' => [
            'title' => 'Error',
            'text' => 'Método de solicitud no válido',
            'icon' => 'error'
        ]
    ]);
}
?>
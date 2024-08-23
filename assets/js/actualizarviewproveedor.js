
    function loadProveedorData(button) {
        var idProveedor = button.getAttribute('data-idproveedor');
        var proveedor = getProveedorData(idProveedor);
        var idMedios = JSON.parse(button.getAttribute('data-idmedios'));
        if (proveedor) {
            console.log('Datos del proveedor:', proveedor);
            document.querySelector('input[name="idprooo"]').value = proveedor.id_proveedor;
            document.querySelector('input[name="nombreIdentificadorp"]').value = proveedor.nombreIdentificador;
            document.querySelector('input[name="nombreProveedorp"]').value = proveedor.nombreProveedor;
            document.querySelector('input[name="nombreFantasiap"]').value = proveedor.nombreFantasia;
            document.querySelector('input[name="rutProveedorp"]').value = proveedor.rutProveedor;
            document.querySelector('input[name="giroProveedorp"]').value = proveedor.giroProveedor;
            document.querySelector('input[name="nombreRepresentantep"]').value = proveedor.nombreRepresentante;
            document.querySelector('input[name="rutRepresentantep"]').value = proveedor.rutRepresentante;
            document.querySelector('input[name="razonSocialp"]').value = proveedor.razonSocial;
            document.querySelector('input[name="direccionFacturacionp"]').value = proveedor.direccionFacturacion;
            document.querySelector('select[name="id_regionp"]').value = proveedor.id_region;
            document.querySelector('select[name="id_comunap"]').value = proveedor.id_comuna;
            document.querySelector('input[name="telCelularp"]').value = proveedor.telCelular;
            document.querySelector('input[name="telFijop"]').value = proveedor.telFijo;
            document.querySelector('input[name="emailp"]').value = proveedor.email;
            document.querySelector('input[name="bonificacion_anop"]').value = proveedor.bonificacion_ano;
            document.querySelector('input[name="escala_rangop"]').value = proveedor.escala_rango;
 if (idMedios && Array.isArray(idMedios)) {
            updateMediosDropdown(idMedios);
        }
        
        } else {
            console.log("No se encontró el proveedor con ID:", idProveedor);
        }
    }


    function getFormData3() {
        const formData = new FormData(document.getElementById('formactualizarproveedor'));

        // Convertir FormData a objeto para imprimirlo
        const dataObject = {};
        formData.forEach((value, key) => {
            dataObject[key] = value;
        });

        console.log(dataObject, "aqui el actualizar señores"); // Imprime el objeto con los datos del formulario

        return {
            nombreIdentificador: dataObject.nombreIdentificadorp,
            nombreProveedor: dataObject.nombreProveedorp,
            nombreFantasia: dataObject.nombreFantasiap,
            rutProveedor: dataObject.rutProveedorp,
            giroProveedor: dataObject.giroProveedorp,
            nombreRepresentante: dataObject.nombreRepresentantep,
            rutRepresentante: dataObject.rutRepresentantep,
            razonSocial: dataObject.razonSocialp,
            direccionFacturacion: dataObject.direccionFacturacionp,
            id_medios: dataObject.id_mediosp,
            id_region: dataObject.id_regionp,
            id_comuna: dataObject.id_comunap,
            telCelular: dataObject.telCelularp,
            telFijo: dataObject.telFijop,
            email: dataObject.emailp || null,
            bonificacion_ano: dataObject.bonificacion_anop,
            escala_rango: dataObject.escala_rangop,
        };
    }

    // Función para enviar el formulario
    async function submitForm3(event) {
        event.preventDefault(); // Evita la recarga de la página
    
        // Obtener los datos del formulario
        let formData = getFormData3();
        let bodyContent = JSON.stringify(formData);
        console.log(bodyContent, "holacon");
    
        let idProveedor = document.querySelector('input[name="idprooo"]').value;
    
        let headersList = {
            "Content-Type": "application/json",
            "apikey": "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc",
            "Authorization": "Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImVreWp4emp3aHhvdHBkZnpjcGZxIiwicm9sZSI6ImFub24iLCJpYXQiOjE3MjAyNzEwOTMsImV4cCI6MjAzNTg0NzA5M30.Vh4XAp1X6eJlEtqNNzYIoIuTPEweat14VQc9-InHhXc"
        };
    
        try {
            // Actualizar el proveedor
            let response = await fetch(`https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/Proveedores?id_proveedor=eq.${idProveedor}`, {
                method: "PATCH",
                body: bodyContent,
                headers: headersList
            });
    
            if (response.ok) {
                let responseText = await response.text(); // Obtén el texto de la respuesta
    
                if (responseText) {
                    let updatedData = JSON.parse(responseText); // Parsea solo si hay contenido
                    console.log("Datos actualizados:", updatedData);
    
                    // Actualiza los campos de la tarjeta con los nuevos datos
                    document.querySelector('.card-body .nombreProveedor').textContent = updatedData.nombreProveedor;
                    document.querySelector('.card-body .nombreFantasia').textContent = updatedData.nombreFantasia;
                    document.querySelector('.card-body .razonSocial').textContent = updatedData.razonSocial;
                    document.querySelector('.card-body .giroProveedor').textContent = updatedData.giroProveedor;
                    document.querySelector('.card-body .direccionFacturacion').textContent = updatedData.direccionFacturacion;
                } else {
                    console.warn("No se recibió ningún dato actualizado en la respuesta.");
                }
    
                mostrarExito('¡Actualización correcta!');
                $('#actualizarProveedor').modal('hide');
                $('#formualarioSoporteProv')[0].reset();
                location.reload();

                // Continuar con la actualización de medios si hay datos en formData.id_medios
                if (formData.id_medios && formData.id_medios.length > 0) {
                    const proveedorMediosData = formData.id_medios.map(id_medio => ({
                        id_proveedor: idProveedor, // Usar el ID existente
                        id_medio: id_medio
                    }));
    
                    let responseProveedorMedios = await fetch("https://ekyjxzjwhxotpdfzcpfq.supabase.co/rest/v1/proveedor_medios", {
                        method: "POST",
                        body: JSON.stringify(proveedorMediosData),
                        headers: headersList
                    });
    
                    if (responseProveedorMedios.ok) {
                        console.log("Medios actualizados correctamente");
                    } else {
                        console.error("Error al actualizar los medios:", await responseProveedorMedios.json());
                    }
                }
    
            } else {
                let errorData = await response.json();
                console.error("Error:", errorData);
                alert("Error, intentelo nuevamente");
            }
        } catch (error) {
            console.error("Error de red:", error);
            alert("Error de red, intentelo nuevamente");
        }
    }
    function updateMediosDropdown(idMedios) {
        const dropdown = document.querySelector('#dropdown1');
        if (!dropdown) {
            console.error('Dropdown no encontrado.');
            return;
        }
    
        const checkboxes = dropdown.querySelectorAll('.dropdown-content input[type="checkbox"]');
        const selectedOptionsContainer = dropdown.querySelector('.selected-options'); // Asegúrate de que exista en tu HTML
        
        // Limpiar el contenedor de opciones seleccionadas
        selectedOptionsContainer.innerHTML = '';
    
        checkboxes.forEach(checkbox => {
            if (idMedios.includes(parseInt(checkbox.value))) {
                checkbox.checked = true;
            } else {
                checkbox.checked = false;
            }
        });
    
    
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
    // Asigna el evento de envío al formulario de actualizar proveedor
    document.getElementById('formactualizarproveedor').addEventListener('submit', submitForm3);
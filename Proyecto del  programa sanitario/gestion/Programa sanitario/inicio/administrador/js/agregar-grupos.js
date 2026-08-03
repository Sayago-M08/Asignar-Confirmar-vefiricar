document.addEventListener("DOMContentLoaded", () => {
    // === 1. LÓGICA PROMOTORAS ===
    const inputPromotora = document.getElementById("buscador-promotora");
    const datalistPromotoras = document.getElementById("promotoras");
    const estadoPromotora = document.getElementById("estado-promotora");

    inputPromotora.addEventListener("input", () => {
        const valor = inputPromotora.value.trim();
        const opcion = Array.from(datalistPromotoras.options).find(opt => opt.value === valor);

        if (opcion) {
            const nombre = opcion.textContent;
            estadoPromotora.textContent = `Seleccionada: ${nombre} (DNI: ${valor})`;
            estadoPromotora.style.backgroundColor = "#d4edda"; // Verde
            estadoPromotora.style.color = "#155724";
        } else if (valor !== "") {
            estadoPromotora.textContent = "DNI no registrado";
            estadoPromotora.style.backgroundColor = "#f8d7da"; // Rojo
            estadoPromotora.style.color = "#721c24";
        } else {
            estadoPromotora.textContent = "Ninguna promotora seleccionada";
            estadoPromotora.style.backgroundColor = "#e0e0e0";
            estadoPromotora.style.color = "#333";
        }
    });

    // === 2. LÓGICA TAREAS ===
    const inputTarea = document.getElementById("buscador-tarea");
    const datalistTareas = document.getElementById("lista-tareas");
    const estadoTarea = document.getElementById("estado-tarea");

    inputTarea.addEventListener("input", () => {
        const valor = inputTarea.value.trim();
        const existe = Array.from(datalistTareas.options).some(opt => opt.value.toLowerCase() === valor.toLowerCase());

        if (existe) {
            estadoTarea.textContent = "Se utilizará tarea existente";
            estadoTarea.style.backgroundColor = "#d4edda"; // Verde
            estadoTarea.style.color = "#155724";
        } else if (valor !== "") {
            estadoTarea.textContent = `Se creará la tarea: "${valor}"`;
            estadoTarea.style.backgroundColor = "#fff3cd"; // Amarillo
            estadoTarea.style.color = "#856404";
        } else {
            estadoTarea.textContent = "Ninguna tarea seleccionada";
            estadoTarea.style.backgroundColor = "#e0e0e0";
            estadoTarea.style.color = "#333";
        }
    });

    // === 3. LÓGICA OPERATIVOS ===
    const inputOperativo = document.getElementById("buscador-operativo");
    const datalistOperativos = document.getElementById("lista-operativos");
    const estadoOperativo = document.getElementById("estado-operativo");

    inputOperativo.addEventListener("input", () => {
        const valor = inputOperativo.value.trim();
        const existe = Array.from(datalistOperativos.options).some(opt => opt.value.toLowerCase() === valor.toLowerCase());

        if (existe) {
            estadoOperativo.textContent = "Se utilizará operativo existente";
            estadoOperativo.style.backgroundColor = "#d4edda"; // Verde
            estadoOperativo.style.color = "#155724";
        } else if (valor !== "") {
            estadoOperativo.textContent = `Se creará el operativo: "${valor}"`;
            estadoOperativo.style.backgroundColor = "#fff3cd"; // Amarillo
            estadoOperativo.style.color = "#856404";
        } else {
            estadoOperativo.textContent = "Ninguno seleccionado";
            estadoOperativo.style.backgroundColor = "#e0e0e0";
            estadoOperativo.style.color = "#333";
        }
    });

    // === 4. LÓGICA LUGAR ===
    const inputLugar = document.getElementById("buscador-lugar");
    const datalistLugares = document.getElementById("lista-lugares");
    const estadoLugar = document.getElementById("estado-lugar");

    inputLugar.addEventListener("input", () => {
        const valor = inputLugar.value.trim();
        const existe = Array.from(datalistLugares.options).some(opt => opt.value.toLowerCase() === valor.toLowerCase());

        if (existe) {
            estadoLugar.textContent = "Se utilizará lugar existente";
            estadoLugar.style.backgroundColor = "#d4edda"; // Verde
            estadoLugar.style.color = "#155724";
        } else if (valor !== "") {
            estadoLugar.textContent = `Se creará el lugar: "${valor}"`;
            estadoLugar.style.backgroundColor = "#fff3cd"; // Amarillo
            estadoLugar.style.color = "#856404";
        } else {
            estadoLugar.textContent = "Ninguno seleccionado";
            estadoLugar.style.backgroundColor = "#e0e0e0";
            estadoLugar.style.color = "#333";
        }
    });
});
document.addEventListener('DOMContentLoaded', () => {
    const btnAgregar = document.getElementById('btn-agregar-asignacion');
    const contenedor = document.getElementById('contenedor-asignaciones');

    btnAgregar.addEventListener('click', () => {
        const filas = contenedor.querySelectorAll('.bloque-asignacion');
        const nuevaFilaNum = filas.length + 1;

        // Clonamos el primer bloque de asignación (Promotora + Tarea)
        const nuevaFila = filas[0].cloneNode(true);

        // Actualizamos el número del h3
        nuevaFila.querySelector('h3').textContent = `Asignación ${nuevaFilaNum}`;

        // Limpiamos los inputs clonados
        const inputs = nuevaFila.querySelectorAll('input');
        inputs.forEach(input => {
            input.value = '';
        });

        // Mostramos el botón de eliminar para la fila clonada
        const btnEliminar = nuevaFila.querySelector('.btn-eliminar');
        if (btnEliminar) {
            btnEliminar.style.display = 'inline-block';
        }

        contenedor.appendChild(nuevaFila);
    });
});

function eliminarFila(boton) {
    const fila = boton.closest('.bloque-asignacion');
    const contenedor = document.getElementById('contenedor-asignaciones');
    
    if (contenedor.querySelectorAll('.bloque-asignacion').length > 1) {
        fila.remove();
        
        // Re-enumeramos los h3 de las asignaciones restantes para que queden ordenadas
        const filasRestantes = contenedor.querySelectorAll('.bloque-asignacion');
        filasRestantes.forEach((filaAct, index) => {
            filaAct.querySelector('h3').textContent = `Asignación ${index + 1}`;
        });
    }
}

document.getElementById('btn-agregar-fecha').addEventListener('click', function() {
    const contenedor = document.getElementById('contenedor-fechas');
    
    // Creamos un nuevo contenedor para la nueva fecha
    const nuevaFila = document.createElement('div');
    nuevaFila.className = 'fila-fecha';
    nuevaFila.style.cssText = 'margin-bottom: 10px; display: flex; align-items: center; gap: 10px;';
    
    // El input tiene que llamarse exactamente "fechas[]" para que PHP lo reciba como array
    nuevaFila.innerHTML = `
        <input type="date" name="fechas[]" required style="padding: 8px;">
        <button type="button" class="btn-eliminar-fecha" style="padding: 6px 10px; cursor: pointer; background-color: #dc3545; color: white; border: none; border-radius: 4px;">Quitar</button>
    `;
    
    // Evento para eliminar la fila si el usuario se arrepiente
    nuevaFila.querySelector('.btn-eliminar-fecha').addEventListener('click', function() {
        nuevaFila.remove();
    });
    
    contenedor.appendChild(nuevaFila);
});
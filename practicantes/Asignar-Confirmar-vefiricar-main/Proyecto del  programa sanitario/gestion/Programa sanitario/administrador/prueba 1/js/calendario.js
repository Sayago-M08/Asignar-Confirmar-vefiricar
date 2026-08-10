
const months = [
    "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
    "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
];

let currentDate = new Date();
let currentMonth = currentDate.getMonth();
let currentYear = currentDate.getFullYear();

// Base de datos de notas ("AÑO-MES-DIA": "texto")
let savedData = {};

// Control de qué día está seleccionado actualmente
let selectedDateKey = null;

const monthYearDisplay = document.getElementById('month-year-display');
const daysContainer = document.getElementById('days-container');
const panelTitle = document.getElementById('panel-title');
const dataInput = document.getElementById('data-input');
const saveBtn = document.getElementById('save-btn');
const deleteBtn = document.getElementById('delete-btn');

function renderCalendar(month, year) {
    daysContainer.innerHTML = '';
    monthYearDisplay.textContent = `${months[month]} ${year}`;

    const firstDayIndex = new Date(year, month, 1).getDay();
    const totalDays = new Date(year, month + 1, 0).getDate();

    // Rellenar días vacíos al comienzo
    for (let i = 0; i < firstDayIndex; i++) {
        const emptyDiv = document.createElement('div');
        emptyDiv.classList.add('day', 'empty');
        daysContainer.appendChild(emptyDiv);
    }

    // Crear los días utilizables
    const today = new Date();
    for (let day = 1; day <= totalDays; day++) {
        const dateKey = `${year}-${month}-${day}`;

        const dayDiv = document.createElement('div');
        dayDiv.classList.add('day');

        // Añadir número del día
        const numberSpan = document.createElement('span');
        numberSpan.classList.add('day-number');
        numberSpan.textContent = day;
        dayDiv.appendChild(numberSpan);

        // Añadir el micro-indicador de texto guardado
        const indicator = document.createElement('div');
        indicator.classList.add('data-indicator');
        dayDiv.appendChild(indicator);

        // Si el día tiene información, activar indicador visual
        if (savedData[dateKey]) {
            dayDiv.classList.add('has-data');
            indicator.textContent = savedData[dateKey]; // Muestra un fragmento del texto
        }

        // Conservar la selección si cambiamos de mes y volvemos
        if (selectedDateKey === dateKey) {
            dayDiv.classList.add('selected');
        }

        // Resaltar el día de hoy real
        if (day === today.getDate() && month === today.getMonth() && year === today.getFullYear()) {
            dayDiv.classList.add('today');
        }

        // EVENTO AL SELECCIONAR EL DÍA
        dayDiv.addEventListener('click', () => {
            // Quitar la clase 'selected' de cualquier otro día renderizado
            document.querySelectorAll('.day.selected').forEach(el => el.classList.remove('selected'));

            // Seleccionar el día actual
            dayDiv.classList.add('selected');
            selectedDateKey = dateKey;

            // Habilitar y actualizar el panel de control lateral
            dataInput.disabled = false;
            saveBtn.disabled = false;
            
            // Habilitar botón de eliminar solo si el día actual tiene datos
            deleteBtn.disabled = !savedData[dateKey];

            panelTitle.textContent = `${day} de ${months[month]} de ${year}`;
            dataInput.value = savedData[dateKey] || '';
            dataInput.focus();
        });

        daysContainer.appendChild(dayDiv);
    }
}

// --- Evento Guardar Datos ---
saveBtn.addEventListener('click', () => {
    if (selectedDateKey) {
        const text = dataInput.value.trim();

        if (text === '') {
            delete savedData[selectedDateKey];
        } else {
            savedData[selectedDateKey] = text;
        }

        // Volvemos a renderizar para que el pequeño indicador verde se actualice al instante
        renderCalendar(currentMonth, currentYear);
    }
});

// --- Evento Eliminar Datos ---
deleteBtn.addEventListener('click', () => {
    if (selectedDateKey && savedData[selectedDateKey]) {
        // Borrar el registro de la base de datos local
        delete savedData[selectedDateKey];

        // Limpiar y resetear el panel lateral de control
        dataInput.value = '';
        dataInput.disabled = true;
        saveBtn.disabled = true;
        deleteBtn.disabled = true;
        panelTitle.textContent = 'Selecciona un día';

        // Volver a renderizar el calendario para limpiar los indicadores visuales
        selectedDateKey = null;
        renderCalendar(currentMonth, currentYear);
    }
});

// --- Navegadores de Meses y Años ---
document.getElementById('prev-month').addEventListener('click', () => {
    currentMonth--; 
    if (currentMonth < 0) { currentMonth = 11; currentYear--; }
    renderCalendar(currentMonth, currentYear);
});

document.getElementById('next-month').addEventListener('click', () => {
    currentMonth++; 
    if (currentMonth > 11) { currentMonth = 0; currentYear++; }
    renderCalendar(currentMonth, currentYear);
});

document.getElementById('prev-year').addEventListener('click', () => {
    currentYear--; 
    renderCalendar(currentMonth, currentYear);
});

document.getElementById('next-year').addEventListener('click', () => {
    currentYear++; 
    renderCalendar(currentMonth, currentYear);
});

// Renderizado Inicial
renderCalendar(currentMonth, currentYear);
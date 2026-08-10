document.addEventListener('DOMContentLoaded', function() {
        
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek'
            },

            events: '../administrador/acciones/grupos.php',

            // Regla del Semáforo: evalúa la fecha de cada objeto JSON
            eventDataTransform: function(eventData) {
                const hoyObj = new Date();
                const anio = hoyObj.getFullYear();
                const mes = String(hoyObj.getMonth() + 1).padStart(2, '0');
                const dia = String(hoyObj.getDate()).padStart(2, '0');
                
                const hoyLocal = `${anio}-${mes}-${dia}`;
                const fechaEvento = String(eventData.start || '').substring(0, 10);

                if (fechaEvento === hoyLocal) {
                    eventData.backgroundColor = '#198754'; // Verde: Hoy
                    eventData.borderColor = '#198754';
                    eventData.textColor = '#ffffff';
                } else if (fechaEvento > hoyLocal) {
                    eventData.backgroundColor = '#ffc107'; // Amarillo: Futuro
                    eventData.borderColor = '#ffc107';
                    eventData.textColor = '#000000';
                } else {
                    eventData.backgroundColor = '#dc3545'; // Rojo: Pasado
                    eventData.borderColor = '#dc3545';
                    eventData.textColor = '#ffffff';
                }
                
                return eventData;
            },

            eventClick: function(info) {
                if (confirm(`¿Querés cancelar la asignación "${info.event.title}"?`)) {
                    info.event.remove();
                    alert('Asignación eliminada de la vista.');
                }
            },
            eventSourceFailure: function(errorObj) {
                console.error("Error al procesar la fuente de eventos:", errorObj);
            }
        });

        calendar.render();
    });
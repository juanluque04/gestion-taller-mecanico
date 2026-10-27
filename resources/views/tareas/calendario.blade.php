@extends('layouts.nav')

@section('titulo', 'Calendario de tareas')

@section('panelContenido')

<div class="container py-4 calendar-wrapper">
    <h2 class="mb-4">Calendario de tareas</h2>

    <div id="calendar"></div>
</div>

@endsection


@section('scripts')


<script>
    document.addEventListener('DOMContentLoaded', function() {

        let calendarEl = document.getElementById('calendar');
        let tareasOriginales = @json($eventos);
        let tareasFiltradas = tareasOriginales;

        function filtrarEventos(estado) {
            if (estado === "todas") return tareasOriginales;
            return tareasOriginales.filter(t => t.estado === estado);
        }

        let calendar = new FullCalendar.Calendar(calendarEl, {
            
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap',
            displayEventTime: false,

            height: 'auto',
            contentHeight: 'auto',
            expandRows: true,
            fixedWeekCount: false,


            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: '' 
            },

            events: tareasFiltradas,

            eventDidMount: function() {
                if (!document.getElementById("insertedFilter")) {

                    let toolbar = calendarEl.querySelector(".fc-toolbar-chunk:nth-child(3)");

                    if (toolbar) {
                        toolbar.innerHTML = `
                            <select id="insertedFilter" class="form-select" style="width:180px;">
                                <option value="todas">Todas</option>
                                <option value="pendiente">Pendientes</option>
                                <option value="en curso">En curso</option>
                                <option value="terminada">Terminadas</option>
                                <option value="revisada">Revisadas</option>
                            </select>
                        `;
                    }

                    document.getElementById("insertedFilter").addEventListener("change", function () {
                        let estado = this.value;

                        tareasFiltradas = filtrarEventos(estado);

                        calendar.removeAllEvents();
                        calendar.addEventSource(tareasFiltradas);
                    });
                }
            },

            eventClick: function(info) {
                @if(auth()->user()->Rol == 'jefe')
                    window.location.href = "tareas/" + info.event.id + "/editar";
                @else
                    window.location.href = "mis-tareas/" + info.event.id;
                @endif
            }

        });

        calendar.render();

        // OCULTAR ÚLTIMA FILA SI SOLO TIENE DÍAS FUERA DEL MES
        setTimeout(() => {
            let currentMonth = calendar.getDate().getMonth();

            document.querySelectorAll(".fc-daygrid-body tr").forEach((tr, index, arr) => {
                if (index === arr.length - 1) {

                    let allOffMonth = true;

                    tr.querySelectorAll("td").forEach(td => {
                        let cellDate = td.getAttribute("data-date");
                        if (cellDate) {
                            let d = new Date(cellDate);
                            if (d.getMonth() === currentMonth) {
                                allOffMonth = false;
                            }
                        }
                    });

                    if (allOffMonth) {
                        tr.classList.add("fc-last-row-hidden");
                    }
                }
            });
        }, 50);


    });
</script>



@endsection

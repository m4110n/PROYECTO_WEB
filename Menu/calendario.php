<?php
session_start();

// Verificar si el usuario está logueado
if (!isset($_SESSION['nombre'])) {
    // Redirigir a la página de inicio de sesión si no está logueado
    header("Location: ../login/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Calendario de Entrada y Salida de Proveedores</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" rel="stylesheet">
    <style>
        /* Estilo para fechas de entrada */
        .entrada {
            background-color: #5cb85c;
            /* Cambia el color de fondo según tus preferencias */
            color: #fff;
            /* Cambia el color del texto si es necesario */
        }

        /* Estilo para fechas de salida */
        .salida {
            background-color: #d9534f;
            /* Cambia el color de fondo según tus preferencias */
            color: #fff;
            /* Cambia el color del texto si es necesario */
        }
    </style>
</head>

<body>
    <div class="container">
        <h1 class="mt-5 mb-4">Calendario de Entrada y Salida de Proveedores</h1>
        <form id="search-form" class="mb-3">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="start-date">Fecha de Inicio:</label>
                    <input type="date" id="start-date" name="start_date" class="form-control">
                </div>
                <div class="form-group col-md-6">
                    <label for "end-date">Fecha de Fin:</label>
                    <input type="date" id="end-date" name="end_date" class="form-control">
                </div>
            </div>
            <button type="button" id="search-button" class="btn btn-primary">Buscar</button>
        </form>
        <div id="calendar"></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
    <script>
        $(document).ready(function() {
            var calendar = $('#calendar').fullCalendar({
                defaultView: 'month',
                editable: false,
                eventLimit: true,
                events: 'cargar_eventos.php',
                eventRender: function(event, element) {
                    if (event.start) {
                        element.addClass('entrada');
                    }
                    if (event.end) {
                        element.addClass('salida');
                    }
                }
            });

            $('#search-button').click(function() {
                var startDate = $('#start-date').val();
                var endDate = $('#end-date').val();

                // Envía una solicitud AJAX para obtener los eventos
                $.ajax({
                    url: 'cargar_eventos.php',
                    type: 'POST',
                    data: {
                        start_date: startDate,
                        end_date: endDate
                    },
                    success: function(events) {
                        calendar.fullCalendar('removeEvents');
                        calendar.fullCalendar('addEventSource', events);
                    },
                    error: function() {
                        alert('Hubo un error al cargar los eventos.');
                    }
                });
            });
        });
    </script>
</body>

</html>
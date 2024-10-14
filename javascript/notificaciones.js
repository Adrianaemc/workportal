$(document).ready(function() {
    // Función para obtener notificaciones y actualizar el menú
    function obtenerNotificaciones() {
        $.ajax({
            url: 'obtener_notificaciones.php',
            method: 'GET',
            dataType: 'json',
            success: function(response) {
                let numNotificaciones = response.count_unread;
                $('#num_notificaciones').text(numNotificaciones > 0 ? numNotificaciones : '0'); // Mostrar "0" si no hay no leídas

                let $dropdownMenu = $('.dropdown-menu');
                $dropdownMenu.empty(); // Limpiar el contenido previo

                // Si hay notificaciones, agregarlas al menú
                if (response.notificaciones.length > 0) {
                    $.each(response.notificaciones, function(index, notificacion) {
                        let claseLeida = notificacion.leida ? '' : 'notificacion-no-leida'; // Clase si no está leída
                        $dropdownMenu.append(
                            `<div class="notificacion ${claseLeida}" data-id="${notificacion.id}">
                                <p>${notificacion.mensaje}</p>
                                <small>${notificacion.fecha}</small>
                            </div>`
                        );
                    });
                } else {
                    // Si no hay notificaciones, mostrar un mensaje en el menú
                    $dropdownMenu.append(`<div class="notificacion"><p>No hay notificaciones.</p></div>`);
                }
            },
            error: function() {
                console.error('Error al obtener notificaciones.');
            }
        });
    }

    // Marcar todas las notificaciones como leídas al abrir el menú
    function marcarNotificacionesLeidas() {
        $.ajax({
            url: 'marcar_leidas.php',
            method: 'POST',
            success: function() {
                $('#num_notificaciones').text('0'); // Reiniciar el conteo a "0" si todas están leídas
            },
            error: function() {
                console.error('Error al marcar las notificaciones como leídas.');
            }
        });
    }

    // Evento al hacer clic en la campanita
    $('#notificaciones').on('click', function(event) {
        event.stopPropagation(); 
        if (!$('.dropdown-menu').hasClass('show')) {
            obtenerNotificaciones(); // Obtener notificaciones solo cuando se abre el menú
            marcarNotificacionesLeidas(); // Marcar como leídas
        }
        $('.dropdown-menu').toggleClass('show'); // Alternar el menú de notificaciones
    });

    // Cerrar el menú al hacer clic fuera
    $(document).on('click', function() {
        $('.dropdown-menu').removeClass('show');
    });

    // Evitar cerrar el menú si se hace clic en el menú mismo
    $('.dropdown-menu').on('click', function(event) {
        event.stopPropagation();
    });

    // Evento para redirigir al hacer clic en cualquier notificación
    $(document).on('click', '.notificacion', function(event) {
        event.stopPropagation();
        let notificacionId = $(this).data('id');

        // Redirigir a mis_postulaciones.php directamente al hacer clic en la notificación
        window.location.href = 'mis_postulaciones.php'; 

        // (Opcional) Aquí puedes marcar la notificación como leída, si deseas
        $.ajax({
            url: 'marcar_leida.php',
            method: 'POST',
            data: { id: notificacionId },
            success: function() {
                // Aquí podrías actualizar el estilo de la notificación, si deseas
                $(`[data-id=${notificacionId}]`).removeClass('notificacion-no-leida'); // Cambiar estilo a leída
            },
            error: function() {
                console.error('Error al marcar la notificación como leída.');
            }
        });
    });

    // Inicializar al cargar la página
    obtenerNotificaciones();
});

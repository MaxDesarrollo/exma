var btnAceptar = document.getElementById('btnAceptar');
var lblMensaje = document.getElementById('lblMensaje');
var tituloModal = document.getElementById('tituloModal');

var btnAceptarButaca = document.getElementById('btnAceptarButaca');
var lblMensajeButaca = document.getElementById('lblMensajeButaca');
var tituloModalButaca = document.getElementById('tituloModalButaca');

var btnAceptarMensaje = document.getElementById('btnAceptarMensaje');
var lblMensajeMensaje = document.getElementById('lblMensajeMensaje');
var tituloModalMensaje = document.getElementById('tituloModalMensaje');

function enviar(boton, titulo, id) {
	// LA LOGICA DE PAGAR Y ELIMINAR CON CHECK IN Y CHECK OUT SON DISTINTAS
	// PAGAR Y ELIMINAR INTERCAMBIAN LA DIRECCION
	// CHECK IN Y CHECK OUT DIRECTAMENTE SON SOLO UNA OPCION ASI QUE SOLO CAMBIA EL MENSAJE
	if (boton == "pagar") {

		lblMensaje.innerHTML = "En verdad desea realizar el pago?";
		link = btnAceptar.href;

		link = link.replace("eliminar", "pagar");

		comienzoId = link.indexOf("pagar") + 6;
		idCliente = link.substring(comienzoId, link.length);
		btnAceptar.href = link.replace("/" + idCliente, "/" + id);

	}
	else if (boton == "eliminar") {

		lblMensaje.innerHTML = "En verdad desea eliminar el registro?";
		link = btnAceptar.href;

		link = link.replace("pagar", "eliminar");

		comienzoId = link.indexOf("eliminar") + 9;
		idCliente = link.substring(comienzoId, link.length);
		btnAceptar.href = link.replace("/" + idCliente, "/" + id);

	}
	else if (boton == "checkin") {

		lblMensaje.innerHTML = "En verdad desea realizar el Check In?";

		// USAR EL ID QUE ME PROPORCIONA PARA CAMBIAR EL CLIENTE
		// AL CUAL CAMBIARLE LA ASISTENCIA
		link = btnAceptar.href;

		comienzoId = link.indexOf("asistencia") + 11;
		idCliente = link.substring(comienzoId, link.length);
		btnAceptar.href = link.replace("/" + idCliente, "/" + id);

	}
	else if (boton == "checkout") {

		lblMensaje.innerHTML = "En verdad desea realizar el Check Out?";

		// USAR EL ID QUE ME PROPORCIONA PARA CAMBIAR EL CLIENTE
		// AL CUAL CAMBIARLE LA ASISTENCIA
		link = btnAceptar.href;

		comienzoId = link.indexOf("asistencia") + 11;
		idCliente = link.substring(comienzoId, link.length);
		btnAceptar.href = link.replace("/" + idCliente, "/" + id);

	}
	else if (boton == "gestionar") {

		lblMensajeButaca.innerHTML = "Desea reasignar o eliminar?";
		tituloModalButaca.innerHTML = titulo;

		gestionButaca('reasignar', id);

	}
	else if (boton == "mensajes") {

		lblMensajeMensaje.innerHTML = "Desea enviar un mensaje sobre el registro, pago o ticket?";
		tituloModalMensaje.innerHTML = titulo;

		enviarMensaje('registro', id);

	}

	tituloModal.innerHTML = titulo;

	// $('#formulario').submit(function() {
	// 	$(".loader-fondo").fadeIn();
	// });
}


var btnRegistroCliente = document.getElementById('btnRegistroCliente');
function registroCliente(sector) {

	if (sector == 'vip') {

		btnRegistroCliente.href = btnRegistroCliente.href.replace("business", "vip");

	}
	else if (sector == 'business') {

		btnRegistroCliente.href = btnRegistroCliente.href.replace("vip", "business");

	}

	cambiarDescuento();
}

var descuentoAnterior = 0;
function cambiarDescuento() {

	var txtDescuento = document.getElementById('txtDescuento');

	btnRegistroCliente.href = btnRegistroCliente.href.replace("/" + descuentoAnterior, "/" + txtDescuento.value);
	descuentoAnterior = txtDescuento.value;

}

function gestionButaca(gestion, id) {

	link = btnAceptarButaca.href;

	if (gestion == 'reasignar') {

		btnAceptarButaca.href = link.replace("eliminar", "reasignar");
		comienzoId = link.indexOf('reasignar') + 10;

	}
	else if (gestion == 'eliminar') {

		btnAceptarButaca.href = link.replace("reasignar", "eliminar");
		comienzoId = link.indexOf('eliminar') + 9;

	}

	if (id != null) {
		// USAR EL ID QUE ME PROPORCIONA PARA CAMBIAR EL CLIENTE
		// AL CUAL CAMBIARLE LA ASISTENCIA
		idCliente = link.substring(comienzoId, link.length);
		btnAceptarButaca.href = link.replace("/" + idCliente, "/" + id);
	}

}

function enviarMensaje(mensaje, id) {

	link = btnAceptarMensaje.href;

	if (mensaje == 'registro') {

		if (link.indexOf('pago') != -1) {
			btnAceptarMensaje.href = link.replace('pago', 'registro');
		}
		else if (link.indexOf('ticket') != -1) {
			btnAceptarMensaje.href = link.replace('ticket', 'registro');
		}

		comienzoId = link.indexOf('registro') + 9;

	}
	else if (mensaje == 'pago') {

		if (link.indexOf('registro') != -1) {
			btnAceptarMensaje.href = link.replace('registro', 'pago');
		}
		else if (link.indexOf('pago') != -1) {
			btnAceptarMensaje.href = link.replace('ticket', 'pago');
		}
		
		comienzoId = link.indexOf('pago') + 5;

	}
	else if (mensaje == 'ticket') {

		if (link.indexOf('registro') != -1) {
			btnAceptarMensaje.href = link.replace('registro', 'ticket');
		}
		else if (link.indexOf('pago') != -1) {
			btnAceptarMensaje.href = link.replace('pago', 'ticket');
		}

		comienzoId = link.indexOf('ticket') + 7;

	}

	if (id != null) {

		idCliente = link.substring(comienzoId, link.length);
		btnAceptarMensaje.href = link.replace("/" + idCliente, "/" + id);

	}

}

// function cargando() {
// 	$(".loader-fondo").fadeIn();
// }

$('.link').on('click', function (e) {
	$(".loader-fondo").fadeIn();
});
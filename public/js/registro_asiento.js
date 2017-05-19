// // La zona VIP
// var vip = [
// 	["A", "B", "C", "D", "E", "F", "G"],
var vip = [
	["A", "B", "C", "D", "E", "F", "G"],
	["", "letra", "01", "02", "03", "04", "05", "06", "07", "08", 
	"09", "10", "11", "12", "13", "14", "15", "", "", "",
	"", "", "", "", "", "", "letra", "16", "17", "18", 
	"19", "20", "21", "22", "23", "24", "25", "26", "27", "28", 
	"29", "30", "", ""]
];

var business1 = [
	["A", "B", "C", "D", "E", "F", "G", "H", "I", "J"],
	["letra", "01", "02", "03", "04", "05", "06", "07", "08", "09", 
	"10", "11", "12", "", "", "letra", "13", "14", "15", "16", 
	"17", "18", "19", "20", "21", "22", "23", "24", "", "", 
	"letra", "25", "26", "27", "28", "29", "30", "31", "32", "33", 
	"34", "35", "36", ""]
];

var business2 = [
	["K", "L", "M", "N", "O", "P", "Q", "R", "S", "T"],
	["letra", "01", "02", "03", "04", "05", "06", "07", "08", "09", 
	"10", "11", "12", "", "", "letra", "13", "14", "15", "16", 
	"17", "18", "19", "20", "21", "22", "23", "24", "", "", 
	"letra", "25", "26", "27", "28", "29", "30", "31", "32", "33", 
	"34", "35", "36", ""]
];

var auspiciadores = [
	["", ""],
	["1", "2", "3", "4", "5", "6",
	"7", "8", "9", "10", "11", "12"]
];


// Para seleccionar o deseleccionar el boton enviar
var btnSubmit = document.getElementById('btnSubmit');
btnSubmit.disabled = true;
// $(btnSubmit).hide();

// $(window).on('load', function() {
	// console.log($('#avisoModal'));
	$('#avisoModal').modal('show');
// });




// tabla = La tabla donde llenare todos los asientos.
// cantFila = Cantidades de filas, estoy aumentando una fila por espacio entre zona y zona
// largoFila = El numero maximo de asiento, igual para todas las filas, solo la cantidad cambia
// orderSillas = Para la imagen, si sera una silla izq, medio o der

// El for:
// Insertara de a una fila, y luego tendra otro for donde se insertara cada celda
var tabla = document.getElementById('tblAsientos');
butacaCliente = document.getElementById('lblAsientoSeleccionado');
var asientoSeleccionado = document.getElementById('asientoSeleccionado');
var anteriorAsientoTexto = '';
var anteriorAsiento;

var cantFila = 32;
var largoFila = 44;
var ordenSillas = 1;

for (var i = 0; i < cantFila; i++) {
	var fila = tabla.insertRow(i);

	for (var j = 0; j < largoFila; j++) {
		var celda = fila.insertCell(j);
	}
}



// celda = tabla.rows[0].cells[0];

// var imagenEscenario = document.createElement("img");
// imagenEscenario.setAttribute('src', '../img/sillas2/escenario.jpg');

// celda.appendChild(imagenEscenario);
// celda.colSpan = largoFila;

celda = tabla.rows[1].cells[21];
celda.className = "escenarioSalido1";

celda = tabla.rows[1].cells[22];
celda.className = "escenarioSalido2";

celda = tabla.rows[1].cells[23];
celda.className = "escenarioSalido3";


celda = tabla.rows[2].cells[21];
celda.className = "escenarioSalido1";

celda = tabla.rows[2].cells[22];
celda.className = "escenarioSalido2";

celda = tabla.rows[2].cells[23];
celda.className = "escenarioSalido3";


celda = tabla.rows[3].cells[21];
celda.className = "escenarioSalido4";

celda = tabla.rows[3].cells[22];
celda.className = "escenarioSalido5";

celda = tabla.rows[3].cells[23];
celda.className = "escenarioSalido6";

largoFila = 44;
var sector = document.getElementById('lblSector').innerHTML;
// console.log(sector);

var posI = 0;
for (var i = 2; i < 9; i++) {
	for (var j = 0; j < largoFila; j++) {

		celda = tabla.rows[i].cells[j];

		if (vip[1][j] != "") {

			if (vip[1][j] == "letra") {
				celda.innerHTML = vip[0][posI];
			}
			else {
				
				if (sector == "VIP") {
					celda.title = vip[0][posI] + vip[1][j];
					celda.id = vip[0][posI] + vip[1][j];

					asiento(celda, 'Vip', celda.id);
				}
				else {
					asientoNoSeleccionable(celda);
				}
			}

		}

	}

	posI++;
}

for (var i = 6; i < 8; i++) {
	for (var j = 19; j < 25; j++) {

		celda = tabla.rows[i].cells[j];
		asientoNoSeleccionable(celda);

	}
}

var posI = 0;
for (var i = 10; i < 20; i++) {
	for (var j = 0; j < largoFila; j++) {

		celda = tabla.rows[i].cells[j];

		if (business1[1][j] != "") {

			if (business1[1][j] == "letra") {
				celda.innerHTML = business1[0][posI];
			}
			else {

				if (sector == "Business") {
					celda.title = business1[0][posI] + business1[1][j];
					celda.id = business1[0][posI] + business1[1][j];

					asiento(celda, 'Business', celda.id);
				}
				else {
					asientoNoSeleccionable(celda);
				}
			}

		}

	}

	posI++;
}

posI = 0;
for (var i = 21; i < 31; i++) {
	for (var j = 0; j < largoFila; j++) {

		celda = tabla.rows[i].cells[j];

		if (business2[1][j] != "") {

			if (business2[1][j] == "letra") {
				celda.innerHTML = business2[0][posI];
			}
			else {

				if (sector == "Business") {
					celda.title = business2[0][posI] + business2[1][j];
					celda.id = business2[0][posI] + business2[1][j];
				
					asiento(celda, 'Business', celda.id);
				}
				else {
					asientoNoSeleccionable(celda);
				}
			}

		}

	}

	posI++;
}



// ASIENTOS YA OCUPADOS
// AO = ASIENTOS OCUPADOS 
// Y EL NOMBRE DEL CARGO DEL CLIENTE
var asientosOcupados = document.getElementById('lblAsientosOcupados').innerHTML.split(",");

var aoClientes = document.getElementById('lblClientesAsientosOcupados').innerHTML.split(",");
var aoNombreCargo = document.getElementById('lblClientesCargoEmpresaAsientosOcupados').innerHTML.split(",");
var aoNombreEmpresa = document.getElementById('lblClientesNombreEmpresaAsientosOcupados').innerHTML.split(",");
//console.log(asientosOcupados);
var asientoOcupadoTexto;
var asientoOcupado;
var largoAsientosOcupados = asientosOcupados.length - 1;

// PARA PONER EL NUMERO COMO ID Y PODER RECORRER EL ARRAY CON LOS DATOS DEL CLIENTE
var contAsientosOcupados = 0;

// LO QUE SE CAMBIA EN EL MODAL DEPENDE DEL CLIENTE
var txtModalCliente = document.getElementById('txtModalCliente');
var txtModalInfoCargoEmpresa = document.getElementById('txtModalInfoCargoEmpresa');
var txtModalInfoNombreEmpresa = document.getElementById('txtModalInfoNombreEmpresa');


// AQUI CONVIERTE LOS ASIENTOS EN OCUPADOS
for (var i = 0; i < largoAsientosOcupados; i++) {
	asientoOcupadoTexto = asientosOcupados[i].trim();

	asientoOcupado = document.getElementById(asientoOcupadoTexto);
	if (asientoOcupado != null) {
		asientoOcupado.innerHTML = "";

		var imagenAsiento = document.createElement("img");
		imagenAsiento.setAttribute('src', '../img/sillas2/sillasOcupadaDerecha.png');
		imagenAsiento.className = "sillasOcupadas sillasOcupadasDerecha ";

		var div = document.createElement("div");
		div.className = "ancho-20";

		div.appendChild(imagenAsiento);
		asientoOcupado.appendChild(div);

		asientoOcupado.setAttribute("onclick", "verInfo(this)");
		asientoOcupado.setAttribute("data-toggle", "modal");
		asientoOcupado.setAttribute("data-target", "#myModal");
		// asientoOcupado.className += " ancho-20";

		asientoOcupado.id = contAsientosOcupados;
	}

	contAsientosOcupados++;
}



function asiento(celda, sector, titulo) {

	var imagenAsiento = document.createElement("img");
	imagenAsiento.setAttribute('src', '../img/sillas2/sillasLibreDerecha.png');
	imagenAsiento.setAttribute("data-toggle", "tooltip");
	imagenAsiento.setAttribute("title", titulo);
	imagenAsiento.className = "sillasLibres sillasLibresDerecha";
	imagenAsiento.setAttribute("onclick", "cambiarEstadoAsiento('" + celda.id + "', '" + sector + "')");

	var div = document.createElement("div");

	div.appendChild(imagenAsiento);
	celda.appendChild(div);

}


function asientoLibre(celda, sector) {
	if (ordenSillas == 1) {
		celda.className = "sillasLibres sillasLibresIzquierda asiento" + sector;
	}
	else if (ordenSillas == 2) {
		celda.className = "sillasLibres sillasLibresMedio asiento" + sector;
	}
	else if (ordenSillas == 3) {
		celda.className = "sillasLibres sillasLibresDerecha asiento" + sector;
	}

	if (ordenSillas == 3) {
		ordenSillas = 1;
	}
	else if (ordenSillas < 3) {
		ordenSillas++;
	}
}

// function asientoNoSeleccionable(celda, sector) {
// 	celda.className = "sillasNoSeleccionables" + sector;
// }

function asientoNoSeleccionable(celda) {
	celda.innerHTML = "";

	var imagenAsiento = document.createElement("img");
	imagenAsiento.setAttribute('src', '../img/sillas2/sillasDesabilitadaDerecha.png');
	imagenAsiento.className = "sillasNoSeleccionables ";

	var div = document.createElement("div");
	// div.className = "ancho-20";

	div.appendChild(imagenAsiento);
	celda.appendChild(div);
}


function verInfo(celda) {

	var pos = celda.id;

	document.getElementById
	txtModalCliente.innerHTML = "Nombre: <strong>" + aoClientes[pos] + "</strong>";
	txtModalInfoCargoEmpresa.innerHTML = "Cargo: <strong>" + aoNombreCargo[pos] + "</strong>";
	txtModalInfoNombreEmpresa.innerHTML = "Empresa: <strong>" + aoNombreEmpresa[pos] + "</strong>";
}

// function asientosAuspiciadores(celda) {
// 	celda.className = "sillasAuspiciadores"
// }
function cambiarEstadoAsiento(celda, asiento) {
	// ANTERIOR ASIENTO, LO GUARDO ANTES DE TRABAJAR CON ASIENTO ACTUAL
	anteriorAsientoTexto = asientoSeleccionado.value;
	$celda = $('#' + celda + ' img');

	if (anteriorAsientoTexto != '') {
		$anteriorAsiento = $('#' + anteriorAsientoTexto + ' img');

		// CAMBIO PRIMERO EL ANTERIOR ASIENTO.
		$anteriorAsiento.removeClass('sillasSeleccionadasDerecha');
		$anteriorAsiento.addClass('sillasLibresDerecha');
	}

	/* Si las celdas son sillas Libres */
	if ($celda.hasClass('sillasLibresDerecha')) {
		$celda.removeClass('sillasLibresDerecha');
		$celda.addClass('sillasSeleccionadasDerecha');

	} /* Si las Sillas son sillas seleccionadas */
	else if ($celda.hasClass('sillasSeleccionadasDerecha')) {
		$celda.removeClass('sillasSeleccionadasDerecha');
		$celda.addClass('sillasLibresDerecha');
	}


	if (celda == butacaCliente.innerHTML) {
		butacaCliente.innerHTML = "No";

		if ($celda.hasClass('sillasLibresDerecha')) {
			$celda.removeClass('sillasLibresDerecha');
			$celda.addClass('sillasSeleccionadasDerecha');
		} /* Si las Sillas son sillas seleccionadas */
		else if ($celda.hasClass('sillasSeleccionadasDerecha')) {
			$celda.removeClass('sillasSeleccionadasDerecha');
			$celda.addClass('sillasLibresDerecha');
		}

		asientoSeleccionado.value = "";
		btnSubmit.disabled = true;
		$(btnSubmit).hide('slow');
	}
	else {
		asientoSeleccionado.value = celda;
		butacaCliente.innerHTML = asientoSeleccionado.value;

		btnSubmit.disabled = false;
		$(btnSubmit).show('slow');
	}

	// console.log(asientoSeleccionado.value);
}

// if ($(window).outerHeight() < 720) {
// 	console.log('Hola');
// }

$('#espacio-blanco').outerHeight($('#navegador').outerHeight());
$('.tabla').outerHeight($(window).outerHeight() - $('#espacio-blanco').outerHeight());
// var navbar2 = document.getElementById('navbar2');

$(window).resize(function() {
	if ($(window).outerHeight() < 720) {
		$('#espacio-blanco').outerHeight($('#navegador').outerHeight());
		$('.tabla').outerHeight($(window).outerHeight() - ($('#navegador').outerHeight() / 2));
		// navbar2.className = "inline container";
	}
	else {
		$('#espacio-blanco').outerHeight($('#navegador').outerHeight());
		$('.tabla').outerHeight($(window).outerHeight() - $('#navegador').outerHeight());
		// navbar2.className = "inline";
	}
});



// // BUSCAR SI HAY REGISTROMODAL Y MOSTRARLO
// var registroModal = document.getElementById('registroModal');

// if (registroModal != null) {
// 	$(registroModal).modal('show');
// }

$('[data-toggle="tooltip"]').tooltip();


// PARA EL MODAL IMAGE
var modalVistaGeneral = document.getElementById('modalVistaGeneral');


// CONSIGO LA IMAGEN Y LA METO EN EL MODAL
var img = document.getElementById('imgVistaGeneral');
var imgModal = document.getElementById('imgModal');
var captionText = document.getElementById('caption');

img.onclick = function() {
	modalVistaGeneral.style.display = "block";
	// imgModal.src = this.src;
	captionText.innerHTML = imgModal.alt;
}

// CONSIGO EL SPAN PARA CERRAR
// var closeSpan = document.getElementsByName('close')[0];

// SI APRETA EL SPAN, SE CIERRA EL MODAL
// closeSpan.onclick = function() {
// 	imgModal.style.display = "none";
// }

function esconder(objeto) {
	if (objeto == "modalVistaGeneral") {
		modalVistaGeneral.style.display = "none";
	}
}


celda = tabla.rows[0].cells[0];

var imagenEscenario = document.createElement("img");
imagenEscenario.setAttribute('src', '../img/sillas2/escenario2.png');
imagenEscenario.style.width = "1295px";
// imagenEscenario.className = "margenIzq";

celda.appendChild(imagenEscenario);
celda.colSpan = largoFila;
celda.className = "fondo-negro";


// $('#btnCollapseNavbar').blur(function () {
// 	if ($('#navbarAsiento').hasClass('in')) {
// 		$('#navbarAsiento').collapse("hide");

// 		// console.log('Entra');
// 	}
// 	else {
// 		// console.log('No entra');
// 	}
// });

// $('#navegador').blur(function () {
// 	// console.log('Hola');

// 	if ($('#navbarAsiento').hasClass('in')) {
// 		$('#navbarAsiento').collapse("hide");
// 	}
// });


// $(document).click(function(evt){
//    var $tgt=$(evt.target);
//    if( !$tgt.is( '#show-anyways') && !$tgt.is($input) ){
//          $input.blur()
//     }
// })

$(document).click(function (evt) {
	var $target = $(evt.target);

	if (!$target.is('#navegador')) {
		$('#navbarAsiento').collapse('hide');
	}
})



// var imgVistaGeneral = document.getElementById('imgVistaGeneral');
// imgVistaGeneral.onclick = function() {
// 	$('#navbarAsiento').collapse("hide");
// }


// function esconderNavBar() {
// 	console.log('hola');
// 	$('#navbarAsiento').collapse('hide');
// }

// $('body').click(function(evt) {
// 	var target = evt.target;

// 	if (target.id != "navbarAsiento") {
// 		$('#navbarAsiento').collapse('hide');
// 	}

// 	console.log(target.id);
// });




$('#formulario').submit(function() {
	$(".loader-fondo").fadeIn();
});

// function cargando() {
// 	$(".loader-fondo").fadeIn();
// }

// $('.link').on('click', function (e) {
// 	// $(".loader-fondo").fadeIn();
// 	e.preventDefault();
// 	console.log('entro');
// });
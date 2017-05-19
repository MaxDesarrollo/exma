// $('.avisoPago').collapse();
// $('#avisoPago3').collapse();

// $("#rbPago1").click(function () {

// 	if (("#rbPago1").is(":checked")) {
// 		console.log('entra');
// 	}
// 	else {
// 		console.log('entra otro');
// 	}

// });



//mostrarAviso($(this), $('#avisoPago1'), $('#avisoPago2'), $('#avisoPago3'));
$('#avisoPago1').fadeOut();
$('#avisoPago2').fadeOut();
$('#avisoPago3').fadeOut();

function mostrarAviso($rbPago, $avisoPago, $avisoPagoEscondido1, $avisoPagoEscondido2) {

	if (($rbPago).is(":checked")) {
		$avisoPago.fadeIn();

		$avisoPagoEscondido1.fadeOut();
		$avisoPagoEscondido2.fadeOut();
	}
	else {
		$avisoPago.fadeOut();

		//$avisoPagoEscondido1.fadeIn();
		//$avisoPagoEscondido2.fadeIn();
	}
}


$('#rbPago1').change(function () {

	mostrarAviso($(this), $('#avisoPago1'), $('#avisoPago2'), $('#avisoPago3'));

}).change();


$('#rbPago2').change(function () {

	mostrarAviso($(this), $('#avisoPago2'), $('#avisoPago1'), $('#avisoPago3'));

}).change();

$('#rbPago3').change(function () {

	mostrarAviso($(this), $('#avisoPago3'), $('#avisoPago1'), $('#avisoPago2'));

}).change();


var txtCiudad = document.getElementById('txtCiudad');
function verificarCiudad() {
	if (txtCiudad.value == 'Otros') {

		txtCiudadOtros.className = "form-control mostrar";
		txtCiudadOtros.required = true;

	}
	else {

		txtCiudadOtros.className = "form-control esconder";
		txtCiudadOtros.required = false;
		txtCiudadOtros.value = "";

	}
}


$('#formulario').submit(function() {
	$(".loader-fondo").fadeIn();
});
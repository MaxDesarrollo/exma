

// $(document).ready( function () {
	$('#tablaPanel').DataTable();
// });
// console.log('Hola');

var tablaPanel_length = document.getElementById('tablaPanel_length');
var tablaPanel_paginate = document.getElementById('tablaPanel_paginate');
var tablaPanel_info = document.getElementById('tablaPanel_info');
var tablaPanel_filter = document.getElementById('tablaPanel_filter');
var tablaPanel = document.getElementById('tablaPanel');

// tablaPanel_length.innerHTML = tablaPanel_length.innerHTML.replace('Show', 'Mostrar');
// tablaPanel_length.innerHTML = tablaPanel_length.innerHTML.replace('entries', 'registros');

// tablaPanel_paginate.innerHTML = tablaPanel_paginate.innerHTML.replace('Previous', 'Anterior');
// tablaPanel_paginate.innerHTML = tablaPanel_paginate.innerHTML.replace('Next', 'Siguiente');

tablaPanel_info.innerHTML = tablaPanel_info.innerHTML.replace('Showing', 'Mostrando');
tablaPanel_info.innerHTML = tablaPanel_info.innerHTML.replace('to', 'a');
tablaPanel_info.innerHTML = tablaPanel_info.innerHTML.replace('of', 'de');
tablaPanel_info.innerHTML = tablaPanel_info.innerHTML.replace('entries', 'registros');

// tablaPanel_filter.innerHTML = tablaPanel_filter.innerHTML.replace('Search', 'Buscar');

// tablaPanel.innerHTML = tablaPanel.innerHTML.replace('No data available in table', 'No hay datos para mostrar');


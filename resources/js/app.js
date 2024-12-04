import * as bootstrap from 'bootstrap'; // Esto hace que bootstrap esté disponible globalmente
window.bootstrap = bootstrap;

import $ from 'jquery';
window.$ = $;
window.jQuery = $;
  
import swal from 'sweetalert2';
window.Swal = swal;

import 'datatables.net-bs5';
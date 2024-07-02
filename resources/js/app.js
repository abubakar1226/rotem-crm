import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

import './DatatableControllers/Datatable.js';
import './DatatableControllers/AppointmentsDatatableController.js';
import './DatatableControllers/SubReportsDatatableController.js';
import './DatatableControllers/LeadsDatatableController.js';
import './DatatableControllers/LeadsNoResponseController.js';
import './DatatableControllers/RefundsDatatableController.js';

import './TableButtonController.js';
import './TableFormModalController.js';

import './LeadStatusModalController.js';

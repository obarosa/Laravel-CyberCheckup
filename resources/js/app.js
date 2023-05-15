require('./bootstrap');

// Complete SortableJS (with all plugins)
// import Sortable from 'sortablejs/modular/sortable.complete.esm.js';
import Sortable from 'sortablejs';
window.Sortable = Sortable;

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

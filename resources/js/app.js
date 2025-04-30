import './bootstrap';
import 'dropzone/dist/dropzone.css';
import Dropzone from 'dropzone';
import Alpine from 'alpinejs';


window.Alpine = Alpine;

Alpine.start();
window.Dropzone = Dropzone;
// Configuración global de Dropzone
Dropzone.autoDiscover = false;
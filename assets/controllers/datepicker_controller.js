import { Controller } from '@hotwired/stimulus';
import { Datepicker } from 'flowbite-datepicker';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    datepicker;

    connect() {
        this.element.type = 'text';

        this.datepicker = new Datepicker(this.element, {
            format: 'yyyy-mm-dd',
            autohide: true,
            container: document.querySelector('dialog[open]') ? 'dialog[open]' : 'body'
        });
    }

    disconnect() {
        if (this.datepicker) {
            this.datepicker.destroy();
        }

        this.element.type = 'date';
    }
}


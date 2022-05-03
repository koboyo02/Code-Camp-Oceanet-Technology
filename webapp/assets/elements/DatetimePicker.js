import 'flatpickr/dist/flatpickr.min.css';
import flatpickr from 'flatpickr';
import { French } from 'flatpickr/dist/l10n/fr';

export default class DateTimePicker extends HTMLInputElement {
	constructor() {
		super();
		flatpickr.localize(French);
	}

	connectedCallback() {
		flatpickr(this, {
			enableTime: true,
			dateFormat: this.getAttribute('date-format') || 'd/m/Y H:i',
			enableTime: !this.hasAttribute('no-time'),
		});
	}
}

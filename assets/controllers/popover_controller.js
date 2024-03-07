import Popover from 'stimulus-popover';

export default class extends Popover {
    async show(t) {
        if (this.hasCardTarget) {
            this.cardTarget.classList.remove('hidden');
            return;
        }

        super.show(t);
    }

    hide() {
        this.hasCardTarget && this.cardTarget.classList.add('hidden');
    }
}

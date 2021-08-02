import { Controller } from 'stimulus';
import { Modal } from 'bootstrap';
import $ from 'jquery';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['modal', 'modalBody', 'modalTitle'];
    static values = {
        formUrl: String,
        formTitle: String,
    }

    // connect() {
    //     console.log('☕️');
    // }

    async openModal() {
        const modal = new Modal(this.modalTarget);
        modal.show();

        this.modalBodyTarget.innerHTML = await $.ajax(this.formUrlValue);
    }

    async openHiddenModalInput(event) {
        event.preventDefault()
        const modal = new Modal(this.modalTarget)
        modal.show()

        console.log('event', event)

        const currentInput = event.target.parent?.closest("input")
        let tmpInput = document.createElement("input")
        tmpInput.type = "text"
        tmpInput.value = currentInput?.value

        console.log('current', event.target.parent)
        console.log('currentInput', currentInput)
        console.log('tmp', tmpInput)
        console.log('formTitle', this.formTitleValue)

        this.modalTitleTarget.innerHTML = this.formTitleValue
        this.modalBodyTarget.innerHTML = tmpInput.outerHTML
    }

    // Prevents EasyAdmin fadeout for non-existing batch action warning modal window
    async preventEasyAdminBatchActionFadeout() {
        const elem = document.getElementsByClassName('modal-backdrop').item(0)
        elem.remove();
    }

    async openModalChangeProjectOnSelected() {
        this.openModal()
        this.preventEasyAdminBatchActionFadeout()
    }

    async openModalChangeUrlOnSelected() {
        this.openModal()
        this.preventEasyAdminBatchActionFadeout()
    }

    async submitForm() {
        const $form = $(this.modalBodyTarget).find('form');
        this.modalBodyTarget.innerHTML = await $.ajax(
            {
                url: this.formUrlValue,
                method: $form.prop('method'),
                data: $form.serialize(),
            }
        );
    }
}

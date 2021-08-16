import { Controller } from 'stimulus'
// import { Modal } from 'bootstrap' // breaks bootstrap Tooltips executions (in EasyAdmin at least)
import Modal from 'bootstrap/js/dist/modal'
import $ from 'jquery'

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['modal', 'modalBody', 'modalTitle']
    static values = {
        formUrl: String,
        formTitle: String,
    }
    modal                 = null
    modalUrl              = ""
    modalTitlePlaceholder = ""
    modalBodyPlaceholder  = ""
    hiddenInputAnchor     = null
    hiddenInputIcon       = null
    currentInput          = null

    connect() {
        console.log('☕️')
        this.modalUrl = this.formUrlValue
        this.modalTitlePlaceholder = this.modalTitleTarget.innerHTML
        this.modalBodyPlaceholder  = this.modalBodyTarget.innerHTML
    }

    async openModal() {
        const modal = new Modal(this.modalTarget)
        modal.show()
        this.modalTitleTarget.innerHTML = this.modalTitlePlaceholder
        this.modalBodyTarget.innerHTML = await $.ajax(this.modalUrl)
    }

    async openHiddenModalInput(event) {
        event.preventDefault()
        const modal = new Modal(this.modalTarget)
        const $button = $(event.currentTarget)
        modal.show()

        const btn = event.target.closest('button')
        this.hiddenInputAnchor = btn.parentNode
        this.hiddenInputIcon = btn.getElementsByTagName('i')[0]
        this.currentInput = document.getElementById(btn?.id.replace("_btn", ""))
        this.currentInput.remove()
        this.currentInput.hidden = false

        this.modalTitleTarget.innerHTML = $button[0]?.children[0]?.title
        this.modalBodyTarget.innerHTML = ''
        this.modalBodyTarget.appendChild(this.currentInput)
    }

    // Prevents EasyAdmin fadeout for non-existing batch action warning modal window
    preventEasyAdminBatchActionFadeout() {
        const elem = document.getElementsByClassName('modal-backdrop').item(0)
        elem.remove()
    }

    async openModalChangeProjectOnSelected() {
        this.openModal()
        // this.preventEasyAdminBatchActionFadeout()
    }

    async openModalChangeUrlOnSelected(event) {
        event.preventDefault()
        // this.preventEasyAdminBatchActionFadeout()
        const $actionLink = $(event.currentTarget)
        this.modalUrl              = $actionLink[0].href
        this.modalTitlePlaceholder = $actionLink[0].innerText
        this.openModal()
    }

    async submitForm() {
        const $form = $(this.modalBodyTarget).find('form')

        this.modalBodyTarget.innerHTML = await $.ajax(
            {
                url: this.formUrlValue,
                method: $form.prop('method'),
                data: $form.serialize(),
            }
        )
    }

    async SymfonyOpenModal(event) {
        this.modalBodyTarget.innerHTML = 'Loading...'
        this.modal = new Modal(this.modalTarget)
        this.modal.show()
        this.modalBodyTarget.innerHTML = await $.ajax(this.formUrlValue)
    }

    async SymfonySubmitForm(event) {
        event.preventDefault()
        const $form = $(this.modalBodyTarget).find('form')

        try {
            await $.ajax({
                url: this.formUrlValue,
                method: $form.prop('method'),
                data: $form.serialize(),
            })

            this.modal.hide()
        } catch (e) {
            this.modalBodyTarget.innerHTML = e.responseText
        }
    }

    modalHidden() {
        console.log('it was hidden!')
    }

    modalHiddenForHiddenInputs() {
        this.currentInput.remove()
        this.currentInput.hidden = true
        this.hiddenInputAnchor.appendChild(this.currentInput)
        this.modalTitleTarget.innerHTML = this.modalTitlePlaceholder
        this.modalBodyTarget.innerHTML  = this.modalBodyPlaceholder
    }
}

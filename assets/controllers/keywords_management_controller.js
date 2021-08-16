import { Controller } from 'stimulus'
import $ from "jquery";

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = [ "table", "form", "search", "multicheck" ]

    connect() {
        this.searchTarget.addEventListener("search", this.searchHandle.bind(this), false)

        // document.getElementsByClassName("kw_client_fieldset")[0]
        //     .getElementsByTagName("input")
        this.formTarget.addEventListener("search", this.formSubmit.bind(this), false)

        // $('.kw_client_fieldset input').on("change", () => {
        //     $(this).closest('form').submit();
        // });
    }

    async searchSubmit(event) {
        event.preventDefault()
    }

    async searchHandle(event) {
        if ("search" === event.type) {
            event.preventDefault()
        } else {
            this.filter()
        }
    }

    filter() {
        const filter = this.searchTarget.value.toUpperCase()
        const rowElements = this.tableTarget.getElementsByClassName("form-group")
        const rowSearchables = Array.from(rowElements).map(el => {
            let row = {}
            row = [
                el.getElementsByClassName("keyword"),
                el.getElementsByClassName("keyword_url"),
                el.getElementsByClassName("keyword_group"),
            ].map(input => {
                return input.item(0).value.toUpperCase()
            })

            return row
        })

        rowSearchables.forEach((row, i) => {
            const filtered = row.filter(key => key.indexOf(filter) > -1)
            if (0 === filtered.length) {
                rowElements[i].style.display = "none"
            } else {
                rowElements[i].style.display = ""
            }
        })
    }

    multicheck() {
        const multicheck = this.multicheckTarget.checked
        const checkboxes = this.tableTarget.getElementsByClassName("dependent")

        checkboxes.forEach(checkbox => {
            let parent = checkbox.closest("tr")
            if (parent.style.display !== "none") {
                checkbox.checked = multicheck
            }
        })
    }

    async formSubmit(event) {
        const $form = $(event.currentTarget)
        const formData = new FormData(event.currentTarget)

        this.kwTableTarget.innerHTML = await $.ajax({
            url: $(this).attr('action'),
            method: "POST",
            data: formData,
            // THIS MUST BE DONE FOR FILE UPLOADING
            contentType: false,
            processData: false,
        })
    }
}

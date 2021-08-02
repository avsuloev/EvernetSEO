import { Controller } from 'stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = [ "table", "search", "multicheck" ]

    connect() {
        this.boundSearchHandle = this.searchHandle.bind(this);
        this.searchTarget.addEventListener("search", this.boundSearchHandle, false)
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
}

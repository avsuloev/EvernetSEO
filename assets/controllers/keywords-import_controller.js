import { Controller } from 'stimulus'
import $ from 'jquery'

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = [ "kwImportForm", "kwImportFile", "kwImportSubmit", "progressValue" ]
    static values = {
        formUrl: String,
    }

    async formSubmit(event) {
        event.preventDefault()

        // const form = event.currentTarget
        // const formData = new FormData(form)
        // const formSerialized = new URLSearchParams(formData).toString()
        // const xhr = new XMLHttpRequest()
        //
        // console.log(formSerialized)
        //
        // this.progressValueTarget.parentElement.hidden = false
        // xhr.open("POST", this.formUrlValue)
        // xhr.addEventListener("load", this.onRequestComplete.bind(this), false)
        // xhr.upload.addEventListener("load", this.onUploadComplete.bind(this), false)
        // xhr.upload.addEventListener("progress", this.onUploadProgress.bind(this), false)
        // xhr.send(formSerialized)


        const $form = $(event.currentTarget)
        const importInput = this.kwImportFileTarget
        const formData = new FormData(event.currentTarget)
        // formData.append(importInput.name, importInput.files[0])

        console.log(this.formUrlValue)

        this.kwImportFormTarget.innerHTML = await $.ajax({
            url: this.formUrlValue,
            method: "POST",
            data: formData,
            // THIS MUST BE DONE FOR FILE UPLOADING
            contentType: false,
            processData: false,
        })
    }

    onUploadProgress(e) {
        if (e.lengthComputable) {
            const percentComplete = (( e.loaded / e.total ) * 100).toFixed(2)

            this.progressValueTarget.setAttribute("style", `width: ${percentComplete}%`)
            this.progressValueTarget.setAttribute("aria-valuenow", percentComplete)
        }
    }

    onRequestComplete() {
        this.progressValueTarget.parentElement.hidden = true
        this.progressValueTarget.setAttribute("style", "width: 0")
        this.progressValueTarget.setAttribute("aria-valuenow", "0")
    }

    onUploadComplete() {
        // this.progressValueTarget.parentElement.hidden = false
    }
}

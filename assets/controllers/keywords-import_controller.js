import { Controller } from 'stimulus';

/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = [ "kwFile", "kwImportForm", "progressValue" ]
    static values = {
        formUrl: String,
    }

    initialize() {
        this.boundOnRequestComplete = this.onRequestComplete.bind(this);
        this.boundOnUploadComplete = this.onUploadComplete.bind(this);
        this.boundOnUploadProgress = this.onUploadProgress.bind(this);
    }

    async formSubmit(event) {
        event.preventDefault()
        const formData = new FormData()
        const xhr = new XMLHttpRequest()
        const kwInput = this.kwFileTarget

        formData.append("upload[file]", kwInput.files[0])
        formData.append("upload[name]", kwInput.value)

        this.progressValueTarget.parentElement.hidden = false
        xhr.open("POST", this.formUrlValue)
        xhr.addEventListener("load", this.boundOnRequestComplete, false)
        xhr.upload.addEventListener("load", this.boundOnUploadComplete, false)
        xhr.upload.addEventListener("progress", this.boundOnUploadProgress, false)
        xhr.send(formData)
    }

    onUploadProgress(event) {
        if (event.lengthComputable) {
            const percentComplete = (( event.loaded / event.total ) * 100).toFixed(2)

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

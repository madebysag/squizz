class ModalController {
    constructor(modalContainer, Btns) {
        this.modalContainer = modalContainer
        this.modal = modalContainer.children[0]
        this.btns = [...Btns]

        this.btns.forEach(btn => {
            btn.addEventListener("click", e => {
                this.show(e.currentTarget)
            })
        })

        this.modalContainer.addEventListener("click", e => {

            if ((e.target == this.modalContainer) || e.target.classList.contains(".btn-cancel")) {
                this.close()
            }
        })
    }

    show(element) {
        this.modal.querySelector(".delete-title").innerText = element.dataset.title
        this.modal.action = `/exams/${element.dataset.key}`

        this.modalContainer.classList.add("active")
    }
    
    close() {
        
        this.modalContainer.classList.remove("active")
    }
}

const modal = document.querySelector(".modal-container");
const deleteBtns = document.querySelectorAll("button.delete-btn");
const modalController = new ModalController(modal, deleteBtns)
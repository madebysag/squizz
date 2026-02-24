class UIController {
    constructor() {

        // Grab Elements from the DOM
        this.questions = [...document.querySelectorAll("main .question-container")]
        this.addQuestionContainer = document.querySelector("main .add-question-container")        
        this.addQuestionBtns = this.addQuestionContainer ? [...this.addQuestionContainer.querySelectorAll("main .add-question-container > button")] : null;

        this.questionLinksContainer = document.querySelector("aside .tabs > #goto")
        
        this.tabTitles = [...document.querySelectorAll("aside .tabs-title > button")]
        this.tabContent = [...document.querySelectorAll("aside .tabs > div")]

        this.formElement = document.querySelector("body > form");

        this.formActionBtns = [...document.querySelectorAll("form aside button[data-action]")]
        

        // this.removeQuestionBtns = [...document.querySelectorAll("main button.delete-question")]


        /** Events */

        // Showing Tabs
        this.tabTitles.forEach(title => {
            title.addEventListener("click", e => {
                this.showTab(e.target.dataset.tabId)
                
            })
        });

        // Adding Questions
        if (this.addQuestionBtns) this.addQuestionBtns.forEach(btn => {
            btn.addEventListener("click", e => {
                this.addQuestion(btn.dataset.type)
                
            })
        });

        // Don't submit when enter is pressed in text input
        this.disableEnterSubmit();

        // Form btns Actions
        this.formActionBtnsEvent()
        
        
        if (this.questions.length > 0) this.addQuestionBtnsEvents();
        

    }

    showTab(id) {
        this.tabContent.forEach((tab, index) => {
            tab.id == id ? tab.classList.add("active") : tab.classList.remove("active")

            // Tab title highlight
            const currentTitle = this.tabTitles[index]
            currentTitle.dataset.tabId == id ? currentTitle.classList.add("active") : currentTitle.classList.remove("active")
        })
    }

    addQuestion(type) {

        // Check if question array is empty the set first question to 1
        let questionNumber;

        if (this.questions.length == 0 ) {

            questionNumber = 1;
        } else {

            // Get the last question Id
            // this.questions = [...document.querySelectorAll("main .question-container")]
            this.lastQuestion = this.questions[this.questions.length - 1]
    
            questionNumber = parseInt(this.lastQuestion.id.match(/\d+/g)[0]) + 1;
        }

        let optionTemplate = "";

        let optionArray, 
            trueOrFalseOption = [], 
            optionEditable = "";

        // Check if question is A-D, A-E, or T/F
        if (type == "A-D" || type == "A-E") {

            const [optionStart, optionEnd] = type.split("-")

            optionArray = optionEnd == "D" ? ["A", "B", "C", "D"] : ["A", "B", "C", "D", "E"]
            
        } else {
            
            optionArray = ["T", "F"];
            trueOrFalseOption = ["TRUE", "FALSE"];
            optionEditable = "disabled"
        }

        
        optionArray.forEach((option, index) => {

            // Check 
            optionTemplate += `
                <div>
                    <span class="text-lg text-muted">${option}</span>
                    <textarea class="text-md" name="answer_${option}_${questionNumber}" ${optionEditable} >${trueOrFalseOption[index] ?? ""}</textarea>
                    <label class="btn-secondary" >
                        ( <input type="radio" value="${option}" name="correct_answer_${questionNumber}" id="question_option_${questionNumber}${option}"> ) Correct Answer
                    </label>
                </div>`;
        })
        

        const questionTemplate = `
        <section class="question-container" id="question_${questionNumber}" data-type="${type}">

                <!-- Questions -->
                <div class="question">
                    <input type="hidden" name="question_type_${questionNumber}" value="${type}">
                    <p class="number">
                        <span class="text-muted">Question </span>
                        <b>${questionNumber}</b>
                    </p>
                    <button type="button" class="btn-secondary delete-question" data-id="question_${questionNumber}" >Delete Question</button>

                    <div class="question-body">
                        <textarea name="question_${questionNumber}" class="text-md"></textarea>
                        <div class="image"><img src="" alt=""></div>
                    </div>
                    
                    <label class="btn-secondary upload-image-btn">Upload Picture <input type="file" name="question_image_${questionNumber}" id="question_${questionNumber}_image" accept=".png, .jpeg"></label>

                    <button type="button" class="btn-secondary delete-uploaded-image">Delete Picture</button>
                        
                </div>

                
                <!-- Options -->
                <p class="text-condensed text-sm text-muted">Options</p>

                <div class="answers">
                    ${optionTemplate}
                </div>
                
            </section>`

        this.addQuestionContainer.insertAdjacentHTML("beforebegin", questionTemplate)

        // Add Questions Links
        this.addGoToLink(questionNumber)

        // Update Questions Array - add the new question
        this.questions = [...document.querySelectorAll("main .question-container")]

        // Add Btns events
        this.addQuestionBtnsEvents()
        
    }

    addQuestionBtnsEvents() {

        const newQuestion = this.questions[this.questions.length - 1]

        // Delete Questions
        const deleteBtn = newQuestion.querySelector("button.delete-question") 
        if (deleteBtn) deleteBtn.addEventListener("click", e => {
            this.removeQuestion(e.target.dataset.id)
            
        })

        // Upload Pic
        const uploadImageBtn = newQuestion.querySelector(".upload-image-btn > input")
        const questionImage = newQuestion.querySelector(".question-body > .image > img")
        uploadImageBtn.addEventListener("change", e => {
            const file = e.target.files[0]
            questionImage.src = URL.createObjectURL(file)

            questionImage.onload = () => {
                URL.revokeObjectURL(questionImage.src)  // Free Memory
            }
        })
        
        // Delete Uploaded Pic
        const deleteUploadImageBtn = newQuestion.querySelector("button.delete-uploaded-image")
        deleteUploadImageBtn.addEventListener("click", e => {
            
            questionImage.src = "#"
        })

    }
    
    removeQuestion(id) {

        const questionNumber = id.match(/\d+/g)[0];        

        this.questions[questionNumber - 1].remove()
        this.questions.splice(questionNumber - 1, 1)

        // Remove question Link
        this.removeGoToLink(questionNumber)

        // Update the numbers, make them sequential
        this.updateQuestionsArray()

        this.updateQuestionLinkArray()
        
    }

    updateQuestionsArray() {

        if (this.questions.length != 0) {
            
            this.questions.forEach((question, index) => {
                const questionNumber = index + 1
    
                // Update alot of things
                // Questions body
                question.id = `question_${questionNumber}`;
    
                question.querySelector(".number > b").innerText = questionNumber;
    
                question.querySelector(".delete-question").dataset.id = `question_${questionNumber}`;
    
                question.querySelector(".question-body > textarea").name = `question_${questionNumber}`;
                
                // Answer and options body
                [...question.querySelectorAll(".answers > div")].forEach(option => {
                    // Text Area Name
                    const textArea = option.children[1]; 
                    textArea.name = textArea.name.replace(/\d+/g, questionNumber)
                    
                    // Correct answer radio input
                    const input = option.children[2].children[0]; 
                    input.name = input.name.replace(/\d+/g, questionNumber)
                    input.id = input.id.replace(/\d+/g, questionNumber)
                })

            })
        }
    }

    addGoToLink(questionNumber) {
        this.questionLinksContainer.innerHTML += `<a href="#question_${questionNumber}" class="goto text-muted">${questionNumber}</a>`
    }

    removeGoToLink(questionNumber) {
        this.questionLinksContainer.children[questionNumber - 1].remove()
    }

    updateQuestionLinkArray() {
        if (this.questionLinksContainer.children.length != 0) {
            
            [...this.questionLinksContainer.children].forEach((link, index) => {
                const questionNumber = index + 1
    
                // Update link href and number
                link.href = `#question_${questionNumber}`;
                link.innerText = questionNumber;
            })
        }
    }

    disableEnterSubmit() {
        this.formElement.addEventListener("keydown", e => {
            if (e.key == "Enter" && e.target.tagName == "INPUT") {                
                e.preventDefault();
            }
        })
    }

    formActionBtnsEvent() {
        this.formActionBtns.forEach(btn => {
            btn.addEventListener("click", e => {
                e.preventDefault()

                this.formElement.action = e.target.dataset.action;

                this.formElement.submit();
            })
        })
    }
}

const uiController = new UIController()
import { formatedTime } from "./utils.js";

class Counter {
    constructor (element) {

        // The timer element
        this.timer = element;

        // Get total time in minutes then convert to seconds
        this.total = parseFloat(this.timer.dataset.totalMinutes) * 60;
        
        // When the counter stops in milliseconds 
        this.stopTime = this.total * 1000;        

    }
    
    /**
     * Reduce time by 1 secs for the specified time
     */
    init() {

        this.intervalId = setInterval(() => {
            this.total--;

            this.render();

        }, 1000)


        setTimeout(() => {
            clearInterval(this.intervalId)
        }, this.stopTime)
        
    }

    render() {

        // set color to red in when time is 2 minute
        if (this.total < 2 * 60) {
            this.timer.classList.add("text-red")            
        }

        this.timer.innerText = formatedTime(this.total)
    }
}

class UIController {

    constructor() {

        // All Questions
        this.questions = [...document.querySelectorAll(".question-container")];
        this.activeQuestion = this.questions[0];

        // Build Questions
        this.gotoQuestionsContainers = [...document.querySelectorAll(".goto-questions")]

        this.gotoQuestionsContainers.forEach(container => {
            this.buildQuestionLinks(container)

            // Events
            container.addEventListener("click", e => {
                e.preventDefault()                

                if (e.target.classList.contains("goto")) {
                    const questionId = e.target.href

                    this.goToQuestion(questionId)
                }
            })
        })

        // Next and Previous Questions
        const navBtns = document.querySelectorAll("footer > .btn-primary")
        this.previousQuestionBtn = navBtns[0]
        this.nextQuestionBtn = navBtns[1]
        
        this.nextQuestionBtn.addEventListener("click", () => { this.goToNextQuestion() })
        this.previousQuestionBtn.addEventListener("click", () => { this.goToPreviousQuestion() })

        // finished Attepmt
        this.finishAtemptPage = document.querySelector(".finish-attempt-container")
        this.finishAtemptBackBtn = this.finishAtemptPage.querySelector("#goBack")
        
        this.finishAtemptBackBtn.addEventListener("click", e => {
            e.preventDefault()
            this.toggleFinishAttemptPage()
        })

    }

    buildQuestionLinks(linksContainer) {
        this.questions.forEach((question, index) => {
            linksContainer.innerHTML += `<a href="#${question.id}" class="goto">${index + 1}</a>`
        })
    }

    goToQuestion(id, formated = false) {

        const questionNumber = formated ? id : id.split("_")[1]

        this.activeQuestion.classList.remove("active")
        
        this.activeQuestion = this.questions[questionNumber - 1]

        this.activeQuestion.classList.add("active")

        // Next btn content
        this.nextQuestionBtn.innerText = (id == this.questions.length) ? "Finish Attempt" : "Next >>"
    }

    goToNextQuestion() {
        const nextQuestionNumber = parseInt(this.activeQuestion.id.split("_")[1]) + 1;
        
        if(nextQuestionNumber <= this.questions.length) {
            this.goToQuestion(nextQuestionNumber, true)
        } else {
            this.toggleFinishAttemptPage()
        }
    }

    goToPreviousQuestion() {
        const previousQuestionNumber = parseInt(this.activeQuestion.id.split("_")[1]) - 1;

        if(previousQuestionNumber > 0) {
            this.goToQuestion(previousQuestionNumber, true)
        }
    }

    toggleFinishAttemptPage () {
        this.finishAtemptPage.classList.toggle("active")
    }

    // todo
    // Next and previous btn
    // Question Navigation, hightlight answered Question
    // Attmept Progress
    // Last Question = Finish Attempt btn
    // clear options
}


const timerElement = document.querySelector(".timer-container > p")
const timer = new Counter(timerElement)
timer.init()

const uiController = new UIController()





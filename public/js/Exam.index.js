import { formatedTime } from "./utils.js";

class Counter {
    constructor (element, otherElement) {

        // The timer element
        this.timer = element;
        this.otherTimers = otherElement;

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

        this.otherTimers.innerHTML = this.timer.outerHTML
    }
}

class UIController {

    constructor() {

        /**Reference Elements from dom */

        this.examForm = document.querySelector("main > form")

        // All Questions
        this.questions = [...document.querySelectorAll(".question-container")];
        this.gotoQuestionsContainers = [...document.querySelectorAll(".goto-questions")]
        

        // Next and Previous Questions
        const navBtns = document.querySelectorAll("footer > .btn-primary")
        this.previousQuestionBtn = navBtns[0]
        this.nextQuestionBtn = navBtns[1]
        
        // Finish Attempt
        this.finishAtemptPage = document.querySelector(".finish-attempt-container")
        this.finishAtemptBackBtn = this.finishAtemptPage.querySelector("#goBack")

        // Answers Options
        this.answerOptions = [...this.examForm.querySelectorAll("input[type='radio']")]

        // Progress Bar UI
        this.finishAttemptprogressBarContainer = this.finishAtemptPage.querySelector(".progress")
        this.progressBarContainer = document.querySelector(".progress")
        this.progressBar = this.progressBarContainer.querySelector(".bar")
        this.progressStats = this.progressBarContainer.querySelector(".questions-stats")

        
        // Active Questions
        this.activeQuestion = this.questions[0];

        // Exam Progress
        this.examProgress = new Set();

        
        /** Add Event Listeners */
        // Build Questions
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
        
        // Next and Previous Btn
        this.nextQuestionBtn.addEventListener("click", () => { this.goToNextQuestion() })
        this.previousQuestionBtn.addEventListener("click", () => { this.goToPreviousQuestion() })

        // finished Attepmt        
        this.finishAtemptBackBtn.addEventListener("click", e => {
            e.preventDefault()
            this.toggleFinishAttemptPage()
        })

        // Answers a question
        // hightlight link
        // increased progress

        // Clear Choices and reduce progress
        this.questions.forEach(question => {
            question.querySelector("button.btn-primary").addEventListener("click", e => {

                let questionNumber;

                [...e.target.parentElement.querySelectorAll("input[type='radio']")].forEach(input => {

                    // Clear input
                    input.checked = false;

                    questionNumber = input.name;

                })

                // Reduce Progress
                this.renderProgress(questionNumber, true)
                
            })
        })

        // Answer a question leads to increase progress
        this.answerOptions.forEach(option => {
            option.addEventListener("change", e => {
                
                this.renderProgress(e.currentTarget.name)
                
                
            })
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
        this.nextQuestionBtn.innerText = (questionNumber == this.questions.length) ? "Finish Attempt" : "Next >>"
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
    // Question Navigation, hightlight answered Question
    // Attmept Progress
    // clear options

    // A Progress tracker
    // // When an option is clicked - increase progress 
    // // Clear option? Reduce progress
    
    renderProgress(questionId, clearChoice = false) {
        if (clearChoice) this.examProgress.delete(questionId)
        else this.examProgress.add(questionId)

        this.progressBar.style.width = `${(this.examProgress.size / this.questions.length) * 100}%` 

        this.progressStats.innerHTML = `<p class="sm">${this.examProgress.size} <span class="text-muted">answered</span></p>
                    <p class="sm">${this.questions.length - this.examProgress.size} <span class="text-muted">left</span></p>`;
        
        this.finishAttemptprogressBarContainer.innerHTML = this.progressBarContainer.innerHTML

        // Handle Link Highlighting
        const questionNumber = questionId.match(/\d+/g)[0]
        this.gotoQuestionsContainers.forEach(container => {
            clearChoice ? container.children[questionNumber - 1].classList.remove("active") :  container.children[questionNumber - 1].classList.add("active")
        })
        
    }
}


const timerElement = document.querySelector("header .timer-container > p")
const otherTimerElement = document.querySelector(".finish-attempt-container .timer-container > p")


const timer = new Counter(timerElement, otherTimerElement)
timer.init()

const uiController = new UIController()





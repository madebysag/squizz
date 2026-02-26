class Submitter {

     /**
     * @param {int} duration // in seconds
     * @param {int} interval // in seconds
     * @param {HTMLElement} formElement 
     *  
     */
    constructor(duration, interval, formElement) {
        
        this.duration = duration * 1000;
        this.form = formElement;
        this.interval = interval * 1000;        
    }

    init() {

        this.intervalId = setInterval(() => {

            this.duration -= this.interval;
            
            this.update();

        }, this.interval)

        setTimeout(() => {
            
            clearInterval(this.intervalId);

            this.submit();

        }, this.duration + 1000);
    }

    update() {
        
        const options = {
            method: "PUT",
            body: new FormData(this.form)
        }
        
        fetch(this.form.action, options)
        .then(res => res.text())
        .then(text => console.log(text)
        )
        
    }
    
    submit() {
        this.form.submit()
    }
    
}


export default Submitter;
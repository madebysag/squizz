class Submitter {

     /**
      * @param {HTMLElement} formElement 
      * @param {bool} manualMode 
     * @param {int} duration // in seconds
     * @param {int} interval // in seconds
     *  
     */
    constructor(duration, formElement, manualMode = false, interval = 10) {
        
        this.duration = duration * 1000;
        this.form = formElement;
        this.manualMode = manualMode;        
        this.interval = interval * 1000;        
    }

    init() {

        if  (!this.manualMode) { // Set it to submit at specified interval            

            this.intervalId = setInterval(() => {
    
                this.duration -= this.interval;
                
                this.update();
    
            }, this.interval)

            setTimeout(() => {
                
                clearInterval(this.intervalId);
    
                this.submit();
    
            }, this.duration + 1000);
            
            
        } else { // only submit when time is up
            
            setTimeout(() => {
                    
                this.submit();
    
            }, this.duration + 1000);
            
        }
        
    }

    update() {
        const formData = new FormData(this.form)

        // Add the hidden method "PUT"
        formData.append("_method", "PUT")

        const options = {
            method: "POST",
            body: formData
        }
        
        fetch(this.form.action, options)
        .then(res => res.text())
        // .then(text => console.log(text))
        
    }
    
    submit() {
        this.form.submit()
    }
    
}


export default Submitter;
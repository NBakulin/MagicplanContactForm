function toggleForm(event) {
    let form = document.getElementById('sales-section');
    let requiredInputs = ['input_company_name', 'input_company_size', 'input_industry', 'input_region'];
    if (event.currentTarget.value === 'customer_support') {
        form.classList.add('display-none')
        for (let key in requiredInputs) {
            document.getElementById(requiredInputs[key]).required = false
        }
    } else {
        form.classList.remove('display-none')
        for (let key in requiredInputs) {
            document.getElementById(requiredInputs[key]).required = true
        }
    }
}

function onSubmit(event) {
    event.preventDefault()
    let token = document.getElementById('csrfToken').content
    let formElement = document.getElementById('contact_form')
    let formData = new FormData(formElement)
    let request = new XMLHttpRequest()
    request.open('POST', '/contact_form')
    request.setRequestHeader('X-CSRF-Token', token)
    request.send(formData)
    //ToDo on success things
}


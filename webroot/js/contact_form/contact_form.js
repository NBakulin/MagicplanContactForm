function toggleForm(event) {
    let form = document.getElementById('sales-section')
    let requiredInputs = ['input_company_name', 'input_company_size', 'input_industry', 'input_region']
    if (event.currentTarget.id === 'customer_support') {
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
    let formElement = document.getElementById('contact_form')
    let formData = new FormData(formElement)
    let request = prepareRequest()
    request.send(formData)
    removeErrorMessages()
    request.onload = function () {
        if (request.status === 200) {
            let body = request.response
            document.write(body)
        } else if(request.status === 500) {
            let unhandledErrorMessage = document.getElementById('unhandled_error')
            unhandledErrorMessage.classList.remove('display-none')
        } else {
            showErrors(request)
        }
    }
}

function prepareRequest() {
    let token = document.getElementById('csrfToken').content
    let request = new XMLHttpRequest()
    request.open('POST', '/contact_form')
    request.setRequestHeader('X-CSRF-Token', token)

    return request
}

function removeErrorMessages() {
    let unhandledErrorMessage = document.getElementById('unhandled_error')
    unhandledErrorMessage.classList.add('display-none')

    let errorElements = document.getElementsByClassName('error-message')
    for (let i = 0; i < errorElements.length; i++) {
        errorElements[i].hidden = true
    }

    let errorContainers = document.getElementsByClassName('error')
    while (errorContainers.length > 1) {
        errorContainers[1].classList.remove('error')
    }
}

function showErrors(request) {
    let body = request.response
    let errors = JSON.parse(body)
    for (let error_name in errors) {
        let input = document.getElementById(error_name)
        input.classList.add('error')
        let errorMessage = document.getElementById('error_' + error_name)
        errorMessage.hidden = false
        for (let errorKey in errors[error_name]) {
            errorMessage.innerHTML = errors[error_name][errorKey]
            break
        }
    }
}


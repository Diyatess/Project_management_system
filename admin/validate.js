
const pincodeInput = document.getElementById('pincode');
    const pincodeValidation = document.getElementById('pincode-validation');
        const emailInput = document.getElementById('email');
        const fnameInput = document.getElementById('fname');
        const lnameInput = document.getElementById('lname');
        const emailValidation = document.getElementById('email-validation');
        const contactInput = document.getElementById('contact');
        const contactValidation = document.getElementById('contact-validation');

        emailInput.addEventListener('input', validateEmail);
        fnameInput.addEventListener('input', validateName);
        lnameInput.addEventListener('input', validatelName);
        contactInput.addEventListener('input', validateContact);
        pincodeInput.addEventListener('input', validatePincode);

        function validateEmail() {
            const email = emailInput.value;
            const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

            if (!email.match(emailPattern)) {
                emailValidation.textContent = 'Please enter a valid email address.';
            } else {
                emailValidation.textContent = '';
            }
        }

        function validateContact() {
            const contact = contactInput.value;
            const indianContactPattern = /^\d{10}$/;

            if (!indianContactPattern.test(contact)) {
                contactValidation.textContent = 'Contact number must be 10 digits and follow the Indian format.';
            } else {
                contactValidation.textContent = '';
            }
        }

        function validateName() {
    const fname = fnameInput.value.trim();
    const fnameError = document.getElementById('fnameError');

    // Check for leading or trailing spaces
    if (fname !== fnameInput.value) {
        fnameError.textContent = 'Name cannot have leading or trailing spaces.';
    } else {
        const words = fname.split(' ');

        // Check if each part is at least 4 characters long, doesn't contain numbers, and doesn't exceed 20 characters
        const invalidPart = words.find(part => part.length < 1 || /\d/.test(part) || part.length > 20);

        if (fname === '') {
            fnameError.textContent = 'Please enter a name.';
        } else if (invalidPart) {
            fnameError.textContent = 'Each word must be at least 4 characters long, not contain numbers, and not exceed 20 characters.';
        } else {
            fnameError.textContent = '';
        }
    }
}

function validatelName() {
    const lname = lnameInput.value.trim();
    const lnameError = document.getElementById('lnameError');

    // Check for leading or trailing spaces
    if (lname !== lnameInput.value) {
        lnameError.textContent = 'Name cannot have leading or trailing spaces.';
    } else {
        const words = lname.split(' ');

        // Check if each part is at least 4 characters long, doesn't contain numbers, and doesn't exceed 20 characters
        const invalidPart = words.find(part => part.length < 1 || /\d/.test(part) || part.length > 20);

        if (lname === '') {
            lnameError.textContent = 'Please enter a name.';
        } else if (invalidPart) {
            lnameError.textContent = 'Each word must be at least 4 characters long, not contain numbers, and not exceed 20 characters.';
        } else {
            lnameError.textContent = '';
        }
    }
}

function validatePincode() {
        const pincode = pincodeInput.value;
        // Regular expression for validating Kerala PIN codes (6 digits starting with 6)
        const pincodePattern = /^6\d{5}$/;

        if (!pincodePattern.test(pincode)) {
            pincodeInput.style.border = '2px solid red';
            pincodeValidation.textContent = 'Please enter a valid Kerala PIN code.';
        } else {
            pincodeInput.style.border = '2px solid green';
            pincodeValidation.textContent = '';
        }
    }
    const dobInput = document.getElementById('dob');
    const dobValidation = document.getElementById('dob-validation');
    const hiredateInput = document.getElementById('hiredate');
    const hiredateValidation = document.getElementById('hiredate-validation');

    // Use the input event for real-time validation
    dobInput.addEventListener('input', validateDob);
    hiredateInput.addEventListener('input', validateHiredate);

    function validateDob() {
        const dobDate = new Date(dobInput.value);
        const currentDate = new Date();
        const minAgeDate = new Date();
        minAgeDate.setFullYear(currentDate.getFullYear() - 21);

        // Check if the selected date is not in the future and the candidate is at least 21 years old
        if (dobDate > currentDate || dobDate > minAgeDate) {
            dobInput.style.border = '2px solid red';
            dobValidation.textContent = 'Date of Birth cannot be a future date, and the candidate should be at least 21 years old.';
        } else {
            dobInput.style.border = '2px solid green';
            dobValidation.textContent = '';
        }
    }

    function validateHiredate() {
        const dobDate = new Date(dobInput.value);
        const hiredateDate = new Date(hiredateInput.value);
        const currentDate = new Date();
    
        // Check if the candidate is at least 21 years old and the hire date is not in the future
        if (dobDate.getFullYear() + 21 > hiredateDate.getFullYear() || hiredateDate > currentDate) {
            hiredateInput.style.border = '2px solid red';
            hiredateValidation.textContent = 'The candidate should be at least 21 years old, and the Hire Date cannot be a future date.';
        } else {
            hiredateInput.style.border = '2px solid green';
            hiredateValidation.textContent = '';
        }
    }
    
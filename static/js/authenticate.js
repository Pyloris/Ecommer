// the below code will check if all the validation if fullfilled.
const submitBtn = document.querySelector(".submit-btn");

function checkValidation() {
    const checks = document.querySelectorAll('.icon');
    const allChecksPassed = Array.from(checks).every((check) => check.classList.contains('tick'));

    if (allChecksPassed) {
        submitBtn.disabled = false;
        submitBtn.classList.remove("disabled");
    } else {
        submitBtn.disabled = true;
        submitBtn.classList.add("disabled");
    }
}

// password visibility
function togglePasswordVisibility(inputId,buttonId) {
    const passwordInput = document.querySelector(`.${inputId}`);
    // const eyeButton = document.querySelector(".eye-button");
    const eyeButton = document.querySelector(`.${buttonId}`);


    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        eyeButton.innerHTML = "🙈"; 
        
    } else {
        passwordInput.type = "password";
        eyeButton.innerHTML = "👁️";
    }
}

// password validation code starts
const password = document.querySelector('.pwd');
var inputValue;

password.addEventListener("keyup",(e)=>{
    validatePwd(e.target.value);
    inputValue = e.target.value;
    checkValidation();
});

password.addEventListener("focusin",(e)=>{
    document.querySelector('.verify-pwd').classList.add("show");
});


function validatePwd(value) {
    const lower = /[a-z]/g;
    const upper = /[A-Z]/g;
    const number = /[0-9]/g;
    const symbol = /[-!$%^&*()_+|~=`{}[:;<>?,.@#\]]/g;

    updateValidationStatus("icon3", value.match(lower));
    updateValidationStatus("icon2", value.match(upper));
    updateValidationStatus("icon4", value.match(number));
    updateValidationStatus("icon5", value.match(symbol));
    updateValidationStatus("icon1", value.length >= 8);
}

function updateValidationStatus(elementId,isValid) {
    const element = document.querySelector(`.${elementId}`);
    // console.log(element);
    
    if (isValid) {
        element.classList.add("tick");
        element.classList.remove("cross");
    } else {
        element.classList.remove("tick");
        element.classList.add("cross");
    }
    
}

// password match code
confirmPassword = document.querySelector(".cPwd");

confirmPassword.addEventListener("keyup",(e)=>{
    pwd_matches(e.target.value);
    checkValidation();
});

confirmPassword.addEventListener("focusin",(e)=>{
    document.querySelector('.cp').classList.add("show");
});

function pwd_matches(value){
    updateValidationStatus("icon6", value===inputValue);
}
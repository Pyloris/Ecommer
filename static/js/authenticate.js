// password validation code starts
const password = document.querySelector('.pwd');
var inputValue;

password.addEventListener("keyup",(e)=>{
    validatePwd(e.target.value);
    inputValue = e.target.value;
});

password.addEventListener("focusin",(e)=>{
    document.querySelector('.verify-pwd').classList.add("show");
});

// password.addEventListener("focusout",(e)=>{
//     document.querySelector('.verify-pwd').classList.remove("show");
// });

function validatePwd(value) {
    const validationRules = [
        { regex: /[a-z]/, checkboxSelector: ".check3" },
        { regex: /[A-Z]/, checkboxSelector: ".check2" },
        { regex: /[0-9]/, checkboxSelector: ".check4" },
        { regex: /[-!$%^&*()_+|~=`{}[:;<>?,.@#\]]/, checkboxSelector: ".check5" }
    ];

    validationRules.forEach(rule => {
        const checkbox = document.querySelector(rule.checkboxSelector);
        checkbox.checked = value.match(rule.regex) !== null;
    });

    const check1Checkbox = document.querySelector(".check1");
    check1Checkbox.checked = value.length >= 8;
}



// password match code
confirmPassword = document.querySelector(".cPwd");

confirmPassword.addEventListener("keyup",(e)=>{
    pwd_matches(e.target.value);
});

confirmPassword.addEventListener("focusin",(e)=>{
    document.querySelector('.cp').classList.add("show");
});


function pwd_matches(value){
    if(value === inputValue){
        document.querySelector(".check6").checked = true;
    }else{
        document.querySelector(".check6").checked = false;
    }
}


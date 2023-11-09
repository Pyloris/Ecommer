function moveField(event, nextInputId, prevInputId) {
    if (event) {
        let currentInput = event.target;
        let currentLen = currentInput.value.length;
        if (event.inputType === "deleteContentBackward") {
            if (currentLen === 0 || prevInputId) {
                document.getElementById(prevInputId).focus();
            }
        } else if (currentLen === 1 && nextInputId) {
            document.getElementById(nextInputId).focus();
        }
    }
}

let inputs = document.querySelectorAll('.otp-input');

inputs.forEach(function(input, index, arr) {
    let nextInputId = index < arr.length - 1 ? arr[index + 1].id : null;
    let prevInputId = index > 0 ? arr[index - 1].id : null;

    input.addEventListener('input', function(event) {
        moveField(event, nextInputId, prevInputId);
    });

    input.addEventListener('focus', function() {
        moveField(null, nextInputId, prevInputId);
    });
});

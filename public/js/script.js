const submitButton = document.getElementById("loginSubmit");
const inputs = document.querySelectorAll('input');

inputs.forEach(input => {
    input.addEventListener("keyup", (e)=> {
        const value = e.currentTarget.value;
        if(value === ""){
            submitButton.disabled = true;
            submitButton.style.backgroundColor = "#d3d3d3";
        } else {
            submitButton.disabled = false;
            submitButton.style.backgroundColor = "#3b82f6";
        }
    })
})
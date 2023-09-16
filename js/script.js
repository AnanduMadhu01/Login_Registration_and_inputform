const modal = document.getElementById('resetModal');
const formmodal = document.getElementById('formcard');
function showAddModal() {
modal.style.display = 'block';
formmodal.style.display = 'none';
}
function closeModal() {
    modal.style.display = 'none';
    formmodal.style.display = 'block';
}
function validate(){
    const form = document.getElementById("form");
    var error1=error2=error3=error4=error5=error6=error7=error8=error9=true;
    if(error1=error2=error3=error4=error5=error6=error7=error8=error9==true){
        //validating name
        var name = document.getElementById('name').value;
        if (name==""){
            document.getElementById('name_msg').textContent = 'Name is required.';
        } else{
            document.getElementById('name_msg').textContent = '';
            error1=false;
        }

        //validating email
        var email = document.getElementById('mail').value;
        const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        if (!emailPattern.test(email)) {
            document.getElementById('email_msg').textContent = 'Please enter a valid email address.';
        } else{
            document.getElementById('email_msg').textContent = '';
            error2=false;
        }

        
        //validating date of birth
        var dob = document.getElementById('date').value;
        if (dob==""){
            document.getElementById('date-msg').textContent = 'Date of birth is required.';
        } else{
            document.getElementById('date-msg').textContent = '';
            error3=false;
        }

        //validating mobile num
        var mob = document.getElementById('number').value;
        var count=10;
        if (mob==""){
            document.getElementById('mob-msg').textContent = 'Mobile number is required.';
        }else if(mob.length <count){
            document.getElementById('mob-msg').textContent = 'Number must be 10 digits';
        } else{
            document.getElementById('mob-msg').textContent = '';
            error4=false;
        }

        //validating checkbox
        const checkboxes = document.querySelectorAll('input[type="checkbox"]');
        let isValid = false;
        for (const checkbox of checkboxes) {
            if (checkbox.checked) {
                isValid = true;
                break;
            }
        }
        if (isValid) {
            document.getElementById('interest_msg').textContent = '';
            error5=false;
        } else {
            document.getElementById('interest_msg').textContent = 'Please select at least one interest.';
        }

        //validating radio button
        const radioButtons = document.querySelectorAll('input[type="radio"]');
        let isSelected = false;

        for (const radioButton of radioButtons) {
            if (radioButton.checked) {
                isSelected = true;
                break;
            }
        }
        if (isSelected) {
            document.getElementById('gntr_msg').textContent = '';
            error6=false;
        } else {
            document.getElementById('gntr_msg').textContent = 'Please select a gender.';
        }

        //validating Address 
        var address = document.getElementById('bio').value;
        const textareaValue = address.trim(); // Remove leading and trailing whitespace
        if (textareaValue === '') {
            document.getElementById('address_msg').textContent = 'Please enter your address.';
        } else {
            document.getElementById('address_msg').textContent = '';
            error7=false;
        }
        
        //Captcha Validation
        var captcha = document.getElementById('captcha').value;
        var random = document.getElementById('ran_captcha').value;
        if(captcha ==""){
            document.getElementById('captcha_msg').textContent = 'Enter the above Captcha.';
        }else if(captcha != random){
            document.getElementById('captcha_msg').textContent = 'Invalid captcha entered.';
        } else{
            document.getElementById('captcha_msg').textContent = '';
            error9=false;
        }

        //validating file
        var fileInput = document.getElementById('file');
  
        // Check if files have been selected
        if (fileInput.files.length > 0) {
            var selectedFile = fileInput.files[0];
            const allowedFileTypes = ['application/pdf']; // Allowed file types
            if (allowedFileTypes.indexOf(selectedFile.type) === -1) {
            document.getElementById('file_msg').textContent = 'Invalid file type. Allowed types is PDF.';
            return;
            }else{
                document.getElementById('file_msg').textContent = '';
                error8=false;
            }
        } else {
            // No files have been selected
            document.getElementById('file_msg').textContent = 'Please select a file.';
        }

    }
    if (error1=error2=error3=error4=error5=error6=error7=error8=error9 == false){
        form.submit();
    }
    
}
    

const name = O("name");
const password = O("password");
const registerUser = O("user");
const errors = O("error");

function validate(form)
{
    form.addEventListener('submit', (e) =>{
        let messages = [];
    
        switch(registerUser.innerHTML){
            case "Administrator Registration":
                messages.push(validateAdminPassword(form.password.value));
                break;
            case "Security Registration":
                messages.push(validateSecurityPassword(form.password.value));
                break;
            case "Client Registration":
                messages.push(validateClientPassword(form.password.value));
                break;
        }
          
        if(messages.length > 0){
            e.preventDefault();
            errors.innerText = messages.join(", ");
        }
    });
}

function validateAreaOfIncidence(field)
{
    if(/[^a-zA-Z0-9.-\s]/.test(field)){
        return "Only spaces, a-z, A-Z, 0-9, - and . allowed in Addresses.\n";
    }
}

function validateAdminPassword(field)
{
    if(field.length < 6){
        return "Password must be at least 6 characters.\n";
    }else if(!/^admin/.test(field)){
        return "An admin the password must be prefixed with 'admin\n";
    }
}

function validateSecurityPassword(field)
{
    if(field.length < 6){
        return "Password must be at least 6 characters.\n";
    }else if(! /^sec/.test(field)){
        return "A security the password must be prefixed with 'sec'\n";
    }
}

function validateClientPassword(field)
{
    if(field.length < 6){
        return "Password must be at least 6 characters.\n";
    }
}

//A method that returns the same object passed if an argument is
//an object otherwise an element with the passed ID is returned
function O(i)
{
    return typeof i == 'object' ? i : document.getElementById(i);
}
const main = document.querySelector('.main');
const registerLink = document.querySelector('.reg-link');  // Refers to the toggle button
const loginForm = document.querySelector('.form-box.login');
const registerForm = document.querySelector('.form-box.register');
const toggleButton = document.querySelector('.popUp-reg');  // Button inside the link

// Event listener for clicking the sign-up or login button
registerLink.addEventListener('click', (event) => {
    event.preventDefault();  // Prevent link default behavior

    // If the main form is in the login state, switch to the register form
    if (registerForm.classList.contains('aktif')) {
        // Show the login form
        registerForm.classList.remove('aktif');
        loginForm.classList.add('aktif');
        toggleButton.innerHTML = 'Sign up';  // Change the button text back to 'Sign up'
        registerLink.classList.add('reg-link');
        registerLink.classList.remove('login-link');
        main.classList.remove('aktif');
    } else {
        // Show the register form
        loginForm.classList.remove('aktif');
        registerForm.classList.add('aktif');
        main.classList.add('aktif');
        toggleButton.innerHTML = 'Login';  // Change the button text to 'Login'
        registerLink.classList.add('login-link');
        registerLink.classList.remove('reg-link');
    }
});


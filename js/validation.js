const form = document.getElementById('form')
const fullname_input = document.getElementById('fullname-input')
const email_input = document.getElementById('email-input')
const password_input = document.getElementById('password-input')
const repeat_password_input = document.getElementById('repeat-password-input')
const profile_image_input = document.getElementById('profile-image-input')
const error_message = document.getElementById('error-message')

form.addEventListener('submit', (e) => {
  let errors = []

  if(fullname_input){
    // If we have a fullname input then we are in the signup
    errors = getSignupFormErrors(fullname_input.value, email_input.value, password_input.value, repeat_password_input.value, profile_image_input.value)
  }
  else{
    // If we don't have a fullname input then we are in the login
    errors = getLoginFormErrors(email_input.value, password_input.value)
  }

  if(errors.length > 0){
    // If there are any errors
    e.preventDefault()
    error_message.innerText  = errors.join(". ")
  }
})

function getSignupFormErrors(fullname, email, password, repeatPassword, profile_image){
  let errors = []

  if(fullname === '' || fullname == null){
    errors.push('Full Name is required')
    fullname_input.parentElement.classList.add('incorrect')
  }
  if(email === '' || email == null){
    errors.push('Email is required')
    email_input.parentElement.classList.add('incorrect')
  }
  if(password === '' || password == null){
    errors.push('Password is required')
    password_input.parentElement.classList.add('incorrect')
  }
  if(password.length < 8){
    errors.push('Password must have at least 8 characters')
    password_input.parentElement.classList.add('incorrect')
  }
  if(password !== repeatPassword){
    errors.push('Password does not match repeated password')
    password_input.parentElement.classList.add('incorrect')
    repeat_password_input.parentElement.classList.add('incorrect')
  }
  if(profile_image === '' || profile_image == null){
    errors.push('Image Profile is required')
    profile_image_input.parentElement.classList.add('incorrect')
  }


  return errors;
}


//login form validation
function getLoginFormErrors(email, password){
  let errors = []

  if(email === '' || email == null){
    errors.push('Email is required')
    email_input.parentElement.classList.add('incorrect')
  }
  if(password === '' || password == null){
    errors.push('Password is required')
    password_input.parentElement.classList.add('incorrect')
  }

  return errors;
}

const allInputs = [fullname_input, email_input, password_input, repeat_password_input, profile_image_input].filter(input => input != null)

allInputs.forEach(input => {
  input.addEventListener('input', () => {
    if(input.parentElement.classList.contains('incorrect')){
      input.parentElement.classList.remove('incorrect')
      error_message.innerText = ''
    }
  })
})
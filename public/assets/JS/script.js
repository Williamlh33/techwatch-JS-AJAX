const loginForm = document.getElementById('login-form')

document.addEventListener('DOMContentLoaded', function(){

    loginForm.addEventListener('submit', (event) => {
        event.preventDefault()
        fetch('/login', {
            method: 'POST',
            body: new FormData(loginForm)
        })

        .then(res => res.json())
        .then(data => {
           
            if (data.status_login === 'success') {
                setTimeout(() => {
                    const modal = document.querySelector('#modal-center');
                    modal.classList.remove('uk-open');
                    modal.classList.add('uk-close');
                }, 800);

                setTimeout(() => {
                UIkit.notification({message: data.message_success, pos: 'top-right'})
                }, 1200) 
            }

            if (data.status_login === 'errors') {
                UIkit.notification({message: data.message_error, pos: 'top-right'})
            }

            if (data.errorsLogin){
                if (data.errorsLogin.identifiant) {
                    const afficheErrorsIdentifiant = document.querySelector('#errorsidentifiant');
                    afficheErrorsIdentifiant.setAttribute("placeholder", data.errorsLogin.identifiant);
                }
            }

        })
    })
})
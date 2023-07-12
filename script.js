document.addEventListener('DOMContentLoaded', function() {
    let urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('error') && urlParams.get('error') === 'no_coinciden') {
        let toast = new bootstrap.Toast(document.querySelector('.toast'));
        toast.show();

        let registroModal = new bootstrap.Modal(document.getElementById('registro'));
        registroModal.show();
    }
});

document.addEventListener('DOMContentLoaded', function() {
    let toastSuccessElement = document.querySelector('#toastSuccess');
    let toastSuccess = new bootstrap.Toast(toastSuccessElement);
    toastSuccess.show();
});

document.addEventListener('DOMContentLoaded', function() {
    let toastAvisoElement = document.querySelector('#toastAviso');
    let toastAviso = new bootstrap.Toast(toastAvisoElement);
    toastAviso.show();
});

document.addEventListener('DOMContentLoaded', function() {
    let toastSesionElement = document.querySelector('#toastSesion');
    let toastSesion = new bootstrap.Toast(toastSesionElement);
    toastSesion.show();
});

document.addEventListener('DOMContentLoaded', function() {
    let urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('error-sesion') && urlParams.get('error-sesion') === 'credenciales-invalidas') {
        let toast = new bootstrap.Toast(document.querySelector('.toast'));
        toast.show();

        let errorSesion = new bootstrap.Modal(document.getElementById('iniciarSesion'));
        errorSesion.show();
    }
});
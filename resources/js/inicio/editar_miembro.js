var telefono = document.getElementById("telefono");
console.log(window.location.origin+'/redesla/resources/intl-tel-input/build/js/utils.js');
window.intlTelInput(telefono, {
    preventInvalidNumbers: true,
    autoPlaceholder: 'polite',
    initialCountry: "MX",
    formatOnDisplay: true,
    separateDialCode: false,
    utilsScript: window.location.origin+'/redesla/resources/intl-tel-input/build/js/utils.js',
    autoHideDialCode: false,
    nationalMode: false,
});
// Simple password generator utility using jQuery

$(document).ready(function() {
    $('#generatePassword').on('click', function() {
        const letters = 'abcdefghijklmnopqrstuvwxyz';
        const numbers = '0123456789';
        let password = '';

        // Add 4 random letters
        for (let i = 0; i < 4; i++) {
            password += letters.charAt(Math.floor(Math.random() * letters.length));
        }

        // Add 4 random numbers
        for (let i = 0; i < 4; i++) {
            password += numbers.charAt(Math.floor(Math.random() * numbers.length));
        }

        // Shuffle the password characters for better randomness (optional but recommended)
        password = password.split('').sort(function(){return 0.5-Math.random()}).join('');

        // Set the password in the fields
        $('#password').val(password);
        $('#password_confirmation').val(password);

        // Optional: Show the generated password to the user (e.g., in a non-modal way)
        // You might want to add a small text element near the button to display it briefly
        // alert('Senha gerada: ' + password); // Avoid using alert for better UX
        // Example: $('#password-feedback').text('Senha gerada: ' + password).show().delay(3000).fadeOut();

         // Trigger input event to satisfy potential validation listeners
         $('#password').trigger('input');
         $('#password_confirmation').trigger('input');
    });
});

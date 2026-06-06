// Common JavaScript functions
$(document).ready(function() {
    // Form validation
    $('form').on('submit', function(e) {
        const requiredFields = $(this).find('[required]');
        let isValid = true;
        
        requiredFields.each(function() {
            if(!$(this).val()) {
                alert('Please fill in all required fields');
                isValid = false;
                return false;
            }
        });
        
        if(!isValid) {
            e.preventDefault();
        }
    });
});

// Utility functions
function formatCurrency(amount) {
    return '$' + parseFloat(amount).toFixed(2);
}

function showMessage(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
    const alert = $('<div class="alert ' + alertClass + '">' + message + '</div>');
    $('body').prepend(alert);
    setTimeout(function() {
        alert.fadeOut('slow', function() {
            $(this).remove();
        });
    }, 3000);
}
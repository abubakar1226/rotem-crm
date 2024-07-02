window.showValidationErrors = (form, errors) => {
    removeValidationErrors(form);

    $.each(errors, function (field, messages) {
        var $input = form.find(`[name="${field}"]`);
        var $errorContainer = $('<div class="text-danger validation-error"></div>');
        $.each(messages, function (index, message) {
            $errorContainer.append('<p>' + message + '</p>');
        });
        $input.closest('.form-group').append($errorContainer);
    });
}

window.removeValidationErrors = (form) => {
    form.find('.validation-error').remove();
}

window.showNotification = (status, message, position = 'top-end', showConfirmButton = false, timer = 15000) => {
    Swal.fire({
        position: position,
        icon: status,
        title: message,
        showConfirmButton: showConfirmButton,
        timer: timer
    });
}

window.submitAjaxPostForm = (form, modal, successCallback = null, errorCallback = null) => {
    form.on('submit', function (e) {
        e.preventDefault();

        const data = form.serializeArray();
        $.ajax({
            url: form.prop('action'),
            data: data,
            type: 'POST',
            success: async (response) => {
                modal.modal('hide');

                showNotification(response.status, response.message);

                if (typeof successCallback === 'function')
                    successCallback(response.configs);
            },
            error: (xhr, status, error) => {
                console.error(xhr, status, error);

                if (xhr.status === 422)
                    showValidationErrors(form, xhr.responseJSON.errors)

                if (typeof errorCallback === 'function')
                    errorCallback();
            }
        });
    });
}

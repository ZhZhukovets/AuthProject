$('#reg_form').on('submit', function (){
    let formData;

    formData = $(this).serializeArray();

    if (validateForm(formData)) {
        $.ajax({
            url: '/ajax/reg.php',
            data: formData,
            method: 'post',
            success: function(data){
                let result = JSON.parse(data);

                if (result.status) {
                    location.replace('/');
                } else if (result.field && result.message) {
                    showError(result.field, result.message);
                }
            }
        });
    }

    return false;
});

$('#auth_form').on('submit', function () {
    let formData;

    formData = $(this).serializeArray();

    if (validateAuthForm(formData)) {
        $.ajax({
            url: '/ajax/auth.php',
            data: formData,
            method: 'post',
            success: function (data) {
                let result = JSON.parse(data);

                if (result.status) {
                    location.replace('/');
                } else if (result.field && result.message) {
                    showError(result.field, result.message);
                }
            }
        });
    }

    return false;
});

$('#logout').on('click', function () {
    $.ajax({
        url: '/ajax/logout.php',
        method: 'post',
        success: function(data){
            if (data) {
                location.replace('/');
            }
        }
    });
})

function validateForm(formData) {
    let password;
    let isRight;
    let validate = true;

    $.each(formData, function (key, value) {
        switch (value.name) {
            case 'login':
                isRight = isFill(value);

                if (isRight) {
                    isRight = strLength(value, 6);
                }

                if (isRight) {
                    hideError(value.name);
                } else {
                    validate = false;
                }

                break;

            case 'password':
                password = value.value;
                isRight = isFill(value);

                if (isRight) {
                    isRight = strLength(value, 6);

                    if (!value.value.match(/\d+/) || !value.value.match(/[a-zA-Z]+/) || value.value.match(/\W+/)) {
                        showError(value.name, 'Должен содержать цифры и буквы');
                        isRight = false;
                    }
                }

                if (isRight) {
                    hideError(value.name);
                } else {
                    validate = false;
                }

                break;

            case 'confirm_password':
                isRight = isFill(value);

                if (isRight) {
                    if (value.value !== password) {
                        showError(value.name, 'Пароли не совпадают');
                        isRight = false;
                    }
                }

                if (isRight) {
                    hideError(value.name);
                } else {
                    validate = false;
                }

                break;

            case 'email':
                if (isFill(value)) {
                    hideError(value.name);
                } else {
                    validate = false;
                }

                break;

            case 'name':
                isRight = isFill(value);

                if (isRight) {
                    isRight = strLength(value, 2);

                    if (value.value.match(/[^A-zА-я\s]/)) {
                        showError(value.name, 'Должен содержать только буквы');
                        isRight = false;
                    }
                }

                if (isRight) {
                    hideError(value.name);
                } else {
                    validate = false;
                }

                break;
        }
    });

    return validate;
}

function validateAuthForm(formData) {
    let validate = true;

    $.each(formData, function (key, value) {
        switch (value.name) {
            case 'login':
                if (isFill(value)) {
                    hideError(value.name);
                } else {
                    validate = false;
                }

                break;

            case 'password':
                if (isFill(value)) {
                    hideError(value.name);
                } else {
                    validate = false;
                }

                break;

        }
    });

    return validate;
}

function isFill(inputObj) {
    if (inputObj.value.length === 0) {
        showError(inputObj.name, 'Заполните поле');

        return false;
    }

    return true;
}

function strLength(inputObj, minLength) {
    if (inputObj.value.length < minLength) {
        showError(inputObj.name, 'Минимальное количество символов ' + minLength);

        return false;
    }

    return true;
}

function showError(name, text) {
    $('[name=' + name + '] + span').text(text).show();
}

function hideError(name) {
    $('[name=' + name + '] + span').text('').hide();
}
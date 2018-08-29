$(function() {
    $("#letter-form").submit(function(e) {
        let form = $(this);
        let url = form.attr('action');
        let letter = $('#letter-input').val();
        $('#letter-text').val(letter);

        $.ajax({
            type: "POST",
            url: url,
            data: form.serialize(),
            success: function(data)
            {
                console.log(data);
                $('.submit-message')
                    .html('<span class="success">Письмо успешно сохранено. Спасибо!</span>')
                    .hide().fadeIn(700);
            },
            error: function(data) {
                $('.submit-message').html('<span class="error">Что-то пошло не так! Пожалуйста, напишите администратору сайта <a href="mailto:lks@sfedu.ru">lks@sfedu.ru</a></span>');
            }
        });

        e.preventDefault();
    });
});

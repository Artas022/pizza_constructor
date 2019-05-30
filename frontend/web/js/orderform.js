

$(document).ready(function () {

        // добавление поля с пиццей
        $('#add_field').on('click', function () {
            $('.pizza_field').filter(':first').clone().appendTo('#pizza-select')
        });

        // удаление дополнительного поля
        $('#delete_field').on('click', function () {
            // если поле одно - не удалять
            if($('.pizza_field').length > 1) {
                $('.pizza_field').filter(':last').remove();
            }
        });

        // валидация поля и отправка AJAX
        $('form').on('submit', function () {

            // проверка номера на валидность
            if($('#phonenumber').val().length < 11)
            {
                alert('Номер телефона введён некорректно! Не менее 11-ти цифр!');
                $('#phonenumber').val('');
                return false;
            }

            // если проверка успешна - попытка отправки AJAX запроса

            // получаем все значения из полей пицц
            var fields= $(".pizza_field").map(function() {
                return $(this).val();
            }).get();

            $.ajax({
                type: 'POST',
                cache: false,
                dataType: "html",
                data: {
                    // номер телефона
                    phonenumber: $('#phonenumber').val(),
                    // пицца/пиццы
                    pizza: fields,
                },
                url: 'ajaxorder',
                success: function () {
                    // чистим поля
                    $('#phonenumber').val('');
                    // очищаем вызванные ранее поля
                    while ($('.pizza_field').length != 1)
                        $('.pizza_field').filter(':last').remove();
                    $('.pizza_field').val(1);
                    // сообщение об успехе
                    alert('Ваш заказ принят! Наш менеджер свяжется с вами для уточнения заказа!');
                }
            });
            return false; // убираем перезагрузку страницы
        });
    });

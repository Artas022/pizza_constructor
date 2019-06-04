

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

        // отправка AJAX
        $('form').on('submit', function () {

            // получаем все значения из полей пицц
            var fields= $(".pizza_field option:selected").map(function() {
                return $(this).attr('value');
            }).get();
            
            $.ajax({
                type: 'POST',
                cache: false,
                dataType: "html",
                data: {
                    // номер телефона
                    phonenumber: $('#phonenumber').val(),
                    // пицца/пиццы
                    pizza: fields
                },
                url: 'ajaxorder',
                success: function (data) {
                    if(data == true)
                    {
                        alert('Заказ успешно принят! Наш менеджер свяжется с вами в ближайшее время!');
                        // чистим поля
                        $('#phonenumber').val('');
                        // очищаем вызванные ранее поля
                        while ($('.pizza_field').length != 1)
                            $('.pizza_field').filter(':last').remove();
                        $('.pizza_field').prop('selectedIndex',0);
                    }
                    else
                    {
                        var answer = $.parseJSON(data);
                        for(var key in answer)
                            alert(answer[key]);
                    }


                }
            });
            return false; // убираем перезагрузку страницы
        });
    });

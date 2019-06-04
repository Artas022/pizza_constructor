
// форма конструктора пицц для клиента


$(document).ready(function () {

    // проверка порции на правильность ввода
    var check_number = function () {
        var temp = String($('.portion').filter(':last').val()).charAt(0);
        return Number(temp);
    };
    // валидация полей порций на правильность ввода данных
    var validate_portions = function () {
        if(($('.portion').filter(':last').val() <= 0) || (check_number() === 0))
            return true;
        else
            return false;
    };
    // удаление доп. поля
    var delete_field = function () {
        if( $('.ingr-port').length > 1 )
        {
            $('.ingr-port').filter(':last').remove();
            // открыть доступ к предыдущему полю
            $('.select-field').filter(':last').prop('disabled',false);
            $('.portion').filter(':last').attr('disabled',false);
        }
    };

    // очистка формы
    var clear_view = function () {
        $('#phonenumber').val('');
        $('#base').val('');
        // очищаем вызванные ранее поля
        while ($('.ingr-port').length > 1)
            delete_field();
        $('.select-field').prop('selectedIndex',0);
        $('.portion').val('');
        $('.ingr-port select option').prop('disabled',false);
    };

    // добавление полей ингредиентов и порций
    $('#add_field').on('click',function () {
        // если поле не заполнено - не создавать поле, пока не будет заполнено
            if (validate_portions())
                alert('Порции не были заданы правильным образом!');
            else {
            // если выбран ингредиент - его нельзя больше выбирать (disabled)
            $('.ingr-port select option:selected').prop('disabled',true);
            // закрыть поле для избежания создания дубликатов
            $('.select-field').filter(':last').attr('disabled','disabled');
            $('.portion').filter(':last').attr('disabled','disabled');
            // сделать клон поля
            $('.ingr-port').filter(':last').clone().appendTo('#recept');
            // новое поле доступно для выбора ингредиента, без возможности создать дубликат поля
            $('.select-field').filter(':last').prop('disabled',false);
            $('.portion').filter(':last').attr('disabled',false);
            $('.ingr-port :input').filter(':last').val('');
        }
    });

    // удаление полей, не удаляя единственное
    $('#delete_field').on('click', function () {
        delete_field();
    });

    $('form').on('submit',function () {

       // проверяем валидность номера
        if( $('#phonenumber').val().length < 8 )
            alert('Номер телефона должен состоять не менее чем из 8-ми цифр!');
        // проверяем валидность основания пиццы
        else if( $('#base').val() < 10 )
            alert('Основание пиццы должно быть хотя бы 10 см!');
        else if(!validate_portions())
        {
            // получаем все выбранные ингредиенты
            var ingridients= $(".select-field option:selected").map(function() {
                return $(this).attr('value');
            }).get();

            var options = $('.portion');
            var portions = $.map(options ,function(option) {
                return option.value;
            });

            $.ajax({
                type: 'POST',
                dataType: "html",
                url: 'ajaxcreate',
                data: {
                    // номер телефона
                    phonenumber: $('#phonenumber').val(),
                    // основание пиццы
                    base: $('#base').val(),
                    // набор ингредиентов
                    ingridient: ingridients,
                    // кол-во порций
                    portion: portions
                },
                success: function (data) {
                    if(data == true)
                    {
                        alert('Заказ принят!');
                        //$('#answer').empty();
                        //$('#answer').append('<p class="lead">Заказ был принят! </p>').html();
                    }
                    else
                    {
                        var answer = $.parseJSON(data);
                        $('#answer').empty();
                        for(var key in answer)
                            $('#answer').append( '<p class="lead">' + answer[key] + '</p>' + '<br>');
                    }
                    clear_view();
                }
            });
      }
        else
        {
            alert('Порции не были заданы правильным образом!');
            $('.portion').filter(':last').val('');
            return false;
        }
        return false;
    })
});
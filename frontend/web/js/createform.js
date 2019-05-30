

$(document).ready(function () {

    // добавление полей ингредиентов и порций
    $('#add_field').on('click',function () {
        // если поле не заполнено - не создавать поле, пока не будет заполнено
        if($('.ingr-port :input').filter(':last').val() == 0)
            alert("Добавьте информацию в поле, прежде чем создавать новое!");
        else {
            // если выбран ингредиент - следующее поле не может его выбирать (disabled)
            // и так до конца кол-ва ингредиентов
            $('.ingr-port select option:selected').prop('disabled',true);
            $('.ingr-port').filter(':last').clone().appendTo('#recept');
            $('.ingr-port :input').filter(':last').val('');
            //$('.ingr-port :input').filter(':last').val('');
        }
    });

    // удаление полей, не удаляя единственное
    $('#delete_field').on('click', function () {
        if( $('.ingr-port').length > 1 )
            $('.ingr-port').filter(':last').remove();
    });

    $('form').on('submit',function () {

       // проверяем валидность номера
        if( $('#phonenumber').val().length < 8 )
        {
            alert('Номер телефона должен состоять не менее чем из 8-ми цифр!');
            return false;
        }

        // проверяем валидность основания пиццы
        if( $('#base').val() < 10 )
        {
            alert('Основание пиццы должно быть хотя бы 10 см!');
            return false;
        }

        // проверяем заполняемость полей

        // получаем всех выбранные ингредиенты
        var options = $('.ingridient_select option:selected');
        var values = $.map(options ,function(option) {
            return option.value;
        });

        // проверяем их на уникальность



        alert(values);
        // 1) все ли поля заполнены
          //  $('.ingridient_select option:selected').each(function () {
           //     console.log(this.text());
           // });
        // 2) есть ли дубликаты



        return false;

    })
    
});
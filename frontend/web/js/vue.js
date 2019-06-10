// получить данные из БД +
// вывести их в поле с именами и значением +
//

Vue.config.productionTip = false;
Vue.config.devtools = false;

var ingr_list = new Vue({
   el: '#select',
   data() {
       return{
           search: '',
           visible: false,
           ingridients: null,
           selected: null,
           list: []
       }
   },
   created() {
       axios.post('select2').then((response) => {
            this.ingridients = JSON.parse(response.data);
       });
   },
   methods:
   {
       // добавление/удаление выбранного ингредиента в/из list
       select_option: function (ingridient) {
           // если такой элемент есть в массиве - удалить его
           for(var i = 0; i < this.list.length; i++)
           {
               if(this.list[i] === ingridient)
               {
                   this.list.splice(i,1);
                   return 0;
               }
           }
           this.list.push(ingridient);
           console.log(this.list);
       },
       // отображение блока
       view: function () {
         if(!this.visible)
             this.visible = true;
       },
       // обновление элементов списка
       update_list: function () {
                
       }
   }
}); 
    
  



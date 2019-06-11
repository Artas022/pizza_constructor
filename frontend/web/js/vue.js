// получить данные из БД +
// вывести их в поле с именами и значением +
// фильтрация полей через AJAX
//

Vue.config.productionTip = false;
Vue.config.devtools = false;

var ingr_list = new Vue({
   el: '#select',
   data() {
       return {
           search: '',
           visible: false,
           ingridients: null,
           selected: null,
           list: []
       }
   },
   methods:
   {
       // добавление/удаление выбранного ингредиента в/из list
       add_ingr: function (ingridient, index) {
           if(!this.delete_ingr(ingridient[index]))
               this.list.push(ingridient[index]);
       },
       // удаление элемента из списка
       delete_ingr: function (ingridient) {
           for(var i = 0; i < this.list.length; i++)
           {
               if(this.list[i] === ingridient)
               {
                   this.list.splice(i,1);
                   return true;
               }
           }
           return false;
       },
       // поиск похожих ингредиентов через AJAX
       search_ingr: function () {
           console.log(this.search);
           if(this.search == '')
           {
               console.log('Запроса нет');
               return true;
           }
           else
           {
               console.log('Попытка связи с сервером!');
               var params = {status: true, search: this.search};
               axios.post('select2', params).then((response) => {
                   console.log(response);
               });
           }
       }
   },
    created() {
        axios.post('select2').then((response) => {
            this.ingridients = JSON.parse(response.data);
        });
    }
});
    
  



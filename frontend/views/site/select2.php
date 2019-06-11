<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<?php
use antkaz\vue\VueAsset;
$this->title= 'Select2';
$this->RegisterCssFile('/css/select2.css');
$this->RegisterJsFile('/js/vue.js');
VueAsset::register($this);
?>
<h1> Select2 </h1>
<div id="select_container" class="container">
    <div id="select_body">
        <div id="select">
            <div>
                <label> Список ингредиентов </label>
                <br>
                <ul id="selected">

                    <li v-for="(item, index) in list"><span class="remove_ingridient" @click="delete_ingr(item)">&times</span>{{ item }}</li>

                    <li><input @click="visible = !visible" type="text" v-model="search" @keyup="search_ingr"></li>

                </ul>

                <ul v-show="visible" id="list">

                    <li class="selected" v-for="(item,index) of ingridients" :value="index" @click="add_ingr(ingridients, index)" >{{ item }}</li>

                </ul>
            </div>
        </div>
    </div>
</div>
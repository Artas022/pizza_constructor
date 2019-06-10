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
        <div @mouseup="visible = false" id="select">
            <label for="select2"> Компонент Vue аналог Select2 </label>
            <br>
            <select v-model="selected" id="select2">
                <option class="active" v-for="(item,index) in ingridients" :value="index" > {{ item }} </option>
            </select>
            <p>{{ selected }}</p>
            <span>
                <label> Список ингредиентов </label>
                <br>
                <input @click="view" type="text">
                <ul v-show="visible" id="list">
                    <!--<li v-for="(item,index) in ingridients" :value="index">{{item}}</li>-->
                    <li v-for="(item,index) in ingridients" :value="index" @click="select_option(item)" >{{item}}</li>
                </ul>
            </span>
            <div id="answer">
                <p class="lead">Массив выбранных ингредиентов: {{ list }}</p>
            </div>
        </div>
</div>
</div>
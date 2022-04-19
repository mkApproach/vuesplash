<template>
    <div id="app">
        <select v-model="selectedKey" v-on:change="selected">
            <option v-for="(value, key) in items">
                {{ key }}
            </option>
        </select>
        
        <select>
            <option v-if="selectedItem" v-for="item in selectedItem">
                {{ item.name }}
            </option>
        </select>
        
        <button>Submit!</button>
    </div>
</template>


<script>
var app = new Vue({
    el: '#app',
    data: {
        selectedKey: '',
        selectedItem: '',
        items: {
            Toyota: [
                { name: 'Aqua' },
                { name: 'Prius' },
                { name: 'Collora' },
                { name: 'Vitz' },
                { name: 'Crown' },
            ],
            Honda: [
                { name: 'N-BOX' },
                { name: 'Freed' },
                { name: 'VEZEL' },
                { name: 'N-WGN' },
                { name: 'Fit' },
            ],
        }
    },
    methods:{
        selected: function(){
            this.selectedItem = this.items[this.selectedKey];
        }
    }
});
</script>


<style>
body {
  background: #2f3640;
  overflow: hidden;
}


#app  {
    width: 300px;
    margin: 20px auto 0 auto;
    padding: 28px;
    border: 1px solid #ffffff;
    border-radius: 5px;
    background-color: transparent;
    
    select {
        display: block;
        width: 100%;
        height: 30px;
        margin: 0 0 20px 0;
        color: #555;
        border: 0;
        border-radius: 5px;
        
        &:last-child {
            margin: 0;
        }
    }
    
    button {
        display: block;
        width: 100px;
        height: 25px;
        margin: 20px auto 0 auto;
        color: #ffffff;
        border: 1px solid #ffffff;
        border-radius: 15px;
        box-shadow: 0;
        background-color: transparent;
        cursor: pointer;
    }
}
</style>
<template>
  <nav class="navbar">
    <RouterLink class="navbar__brand" to="/">
      アプローチの ちいさな写真館
    </RouterLink>
    <div class="navbar__menu">
      <div>
        <div class="sidebar-select">
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
        </div>
      </div>
      <div v-if="isLogin" class="navbar__item">
        <button class="button" @click="showForm = ! showForm">
          <i class="icon ion-md-add"></i>
          写真の投稿
        </button>
      </div>
      <span v-if="isLogin" class="navbar__item">
        {{ username }}
      </span>
      <div v-else class="navbar__item">
        <RouterLink class="button button--link" to="/login">
          ログイン / 登録
        </RouterLink>
      </div>
    </div>
    <PhotoForm v-model="showForm" />
  </nav>
</template>

<script>
import PhotoForm from './PhotoForm.vue'
export default {
  components: {
    PhotoForm
  },
  data () {
    return {
      showForm: false,

      selectid: '',
      selectedKey: '',
      selectedItem: '',
      items: {
          ユニフォーム: [
              { name: '野　球' },
              { name: 'サッカー' },
              { name: 'フットサル' },
              { name: 'マラソン' },
              { name: 'バレーボール' },
          ],
          その他: [
              { name: 'マスク' },
              { name: 'タオル' },
              { name: '抱き枕' },
              { name: 'クッション' },
              { name: 'Fit' },
          ],
      }
    }
  },
  methods:{
      selected: function(){
          this.selectedItem = this.items[this.selectedKey];
      }
  },
  computed: {
    isLogin () {
      return this.$store.getters['auth/check']
    },
    username () {
      return this.$store.getters['auth/username']
    }
  }
}
</script>

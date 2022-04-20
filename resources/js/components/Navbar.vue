<template>
  <nav class="navbar">
    <RouterLink class="navbar__brand" to="/">
      アプローチの ちいさな写真館
    </RouterLink>
    <div class="navbar__menu">
      <div>
        <div class="item_select">
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

      selectedKey: '全て表示',
      selectedItem: { '全て表示':{ name: '全て' }},
     
      items: {
        全て表示: [
              { name: '全て' },
          ],
          ユニフォーム: [
              { id: '2222', name: '野　球' },
              { id: '2222', name: 'サッカー' },
              { id: '2222', name: 'フットサル' },
              { id: '2222', name: 'マラソン' },
              { id: '2222', name: 'バレーボール' },
          ],
          その他: [
              { id: '2222', name: 'マスク' },
              { id: '2222', name: 'タオル' },
              { id: '2222', name: '抱き枕' },
              { id: '2222', name: 'クッション' },
              { id: '2222', name: 'Fit' },
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

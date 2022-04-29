<template>
  <nav class="navbar">
    <RouterLink class="navbar__brand" to="/">
      アプローチの ちいさな写真館
    </RouterLink>
    <div class="navbar__menu">
           
        <div class="input-group"　style="display:inline-flex">
            <div class="input-group-major">大分類</div>
            <select v-model="selectedMajor" v-on:change="select_change_major">
<!--            　<option value="">選択して下さい</option>  -->
              <option v-for="item in selectMajors" :value="item.major_id" v-bind:major="item.major_id" :key="item.major_id" >
                {{ item.name }}
              </option>
            </select>
            <div class="input-group-middle">中分類</div>
            <select v-model="selectedMiddle" v-on:change="select_change_middle">
<!--               <option value="">選択して下さい</option>  -->
              <option v-for="item in selectMiddles":value="item.middle_id" :key="item.middle_id">
                    {{ item.name }}
              </option>
            </select>
            <div class="input-group-subcategory">小分類</div>
            <select v-model="selectedSubcategory" v-on:change="select_change_subcategory">
<!--               <option value="">選択して下さい</option>  -->
              <option v-for="item in selectSubcategorys":value="item.subcategory_id" :key="item.subcategory_id">
                    {{ item.name }}
              </option>
            </select>        
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
    PhotoForm,
  },
  
  data () {
    return {
        selectMajors: [],
        selectMiddles: [],
        selectSubcategorys: [],

        selectedMajor: '*',
        selectedMiddle: '*',
        selectedSubcategory: '*',

        showForm: false,
    }
  },
  
  methods:{

      async select_change_major() {  
          this.selectedMiddle = '*'
          this.selectedSubcategory = '*'
          await this.$store.dispatch('auth/majorchange', this.selectedMajor)
          await this.$store.dispatch('auth/middlechange', this.selectedMiddle)
          await this.$store.dispatch('auth/subcategorychange', this.selectedSubcategory)
       },

      async select_change_middle() {
          await this.$store.dispatch('auth/middlechange', this.selectedMiddle)
          await this.$store.dispatch('auth/subcategorychange', this.selectedSubcategory)
      },

      async select_change_subcategory() {
          await this.$store.dispatch('auth/subcategorychange', this.selectedSubcategory)
      },

      async ajaxGetMajorList() {
          await axios.get(`./api/majorclass`).then((res) => {
              this.selectMajors = res.data
          })
          .catch((error) => {
              this.selectMajors = []
          });
      },

      async ajaxGetMiddleList() {
          await axios.get(`./api/middleclass/${this.selectedMajor}`)
              .then((res) => { 
                  this.selectMiddles = res.data
              })
              .catch((error) => {
                  this.selectMiddles = []
              });
      },

      async ajaxGetSubcategoryList() {
          await axios.get(`./api/subcategoryclass/${this.selectedMajor}/${this.selectedMiddle}`)
              .then((res) => {
                  this.selectSubcategorys = res.data
              })
              .catch((error) => {
                  this.selectSubcategorys = []
              });
      },

  },

  computed: {
      isLogin () {
          return this.$store.getters['auth/check']
      },
      username () {
          return this.$store.getters['auth/username']
      }
  },

  mounted() {
      this.ajaxGetMajorList()
  },

  watch: {
      async selectedMajor() {
          await this.ajaxGetMiddleList()
          await this.ajaxGetSubcategoryList()
      },
      
      async selectedMiddle() {
          await this.ajaxGetSubcategoryList()
      },    
  },
}
</script>

/////////////////////////////////////////////////
//                                             //
//             PhotoList.vue                   //
//                                             //
//     写真フォーム （初期一覧表画面 全体）　        //
//                                             //
//                                             //
/////////////////////////////////////////////////
<template>
  <div class="photo-list">
    <div class="grid">
      <Photo
        class="grid__item"
        v-for="photo in photos"
        :key="photo.id"
        :item="photo"
        @like="onLikeClick"
        @remove="onRemoveClick"
      />
    </div>
    <Pagination :current-page="currentPage" :last-page="lastPage" />
  </div>
</template>

<script>
import { OK } from '../util'
import Photo from '../components/Photo.vue'
import Pagination from '../components/Pagination.vue'
export default {
  components: {
    Photo,
    Pagination
  },
  props: {
    page: {
      type: Number,
      required: false,
      default: 1
    }
  },
  data () {
      return {
          photos: [],
          currentPage: 0,
          lastPage: 0,
          major_id: '*',
          middle_id: '*',
          subcategory_id: '*',
      }
  },
  methods: {

    async fetchPhotos () {
     
      const response = 
          await axios.get(`./api/photos/?page=${this.page}&major_id=${this.major_id}&middle_id=${this.middle_id}&subcategory_id=${this.subcategory_id}`)
      if (response.status !== OK) {
        
        this.$store.commit('error/setCode', response.status)
        return false
      }
      this.photos = response.data.data
      this.currentPage = response.data.current_page
      this.lastPage = response.data.last_page
    },
    onLikeClick ({ id, liked }) {


      console.log(this.selectedMajorid)

      if (! this.$store.getters['auth/check']) {
        alert('いいね機能を使うにはログインしてください。')
        return false
      }
      if (liked) {
        this.unlike(id)
      } else {
        this.like(id)
      }
    },
    onRemoveClick ({ id, liked }) {
      if (! this.$store.getters['auth/check']) {
        alert('削除機能を使うにはログインしてください。')
        return false
      }
      this.remove(id)
    },
    async like (id) {
      const response = await axios.put(`./api/photos/${id}/like`)
      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      this.photos = this.photos.map(photo => {
        if (photo.id === response.data.photo_id) {
          photo.likes_count += 1
          photo.liked_by_user = true
        }
        return photo
      })
    },
    async unlike (id) {
      const response = await axios.delete(`./api/photos/${id}/like`)
      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      this.photos = this.photos.map(photo => {
        if (photo.id === response.data.photo_id) {
          photo.likes_count -= 1
          photo.liked_by_user = false
        }
        return photo
      })
    },
    async remove (id) {
      const response = await axios.put(`./api/photos/${id}/remove`)
      if (response.status !== OK) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      console.log(id)
   
      this.$router.push(`./$`)
 
    },

  },
  computed: {
      foo_major() {
          return this.major_id = this.$store.getters['auth/selectedMajorid']; 
      },
      foo_middle() {
          return this.middle_id = this.$store.getters['auth/selectedMiddleid']; 
      },
      foo_subcategory () {
          return this.subcategory_id = this.$store.getters['auth/selectedSubcategoryid']; 
      },
  },
  watch: {
    async foo_major (val, old) {
         await this.fetchPhotos()
    },
    async foo_middle (val, old) {
         await this.fetchPhotos()
    },
    async foo_subcategory (val, old) {
         await this.fetchPhotos()
    },
    $route: {
      async handler () {
//???          this.major_id = this.$store.getters['auth/selectedMajorid'] 
          await this.fetchPhotos()
      },
      immediate: true
    }
  }
}
</script>
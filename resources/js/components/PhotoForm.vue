/////////////////////////////////////////////////
//                                             //
//                                             //
//          写真投稿　フォーム                    //
//                                             //
//                                             //
/////////////////////////////////////////////////
<template>
  <div v-show="value" class="photo-form">
    <h2 class="title">写真の投稿</h2>
    <div v-show="loading" class="panel">
      <Loader>Sending your photo...</Loader>
    </div>



    <form v-show="! loading" class="form" @submit.prevent="submit">
      <div class="errors" v-if="errors">
        <ul v-if="errors.photo">
          <li v-for="msg in errors.photo" :key="msg">{{ msg }}</li>
        </ul>
      </div>
      <input class="form__item" type="file" @change="onFileChange">
      <output class="form__output" v-if="preview">
        <img :src="preview" alt="">
      </output>

      <table class="form-out">
        <div>
        <tr>
        <td><label for="write-name">書込ファイル名</label></td>
        <td><input type="text" size="38" class="form__item" id="write-name" v-model="writeForm.file_name"></td>
        </tr>
        
        <tr>
        <td><label for="write-name">商　品　名</label></td>
        <td><input type="text" size="38" class="form__item" id="write-name" v-model="writeForm.productname_j"></td>
        </tr>

        <tr>
        <td><label for="write-name">価　 格</label></td>
        <td><input type="text" size="16" class="form__item" id="write-name" v-model="writeForm.price"></td>
        </tr>

        <div class="form__button">
            <button type="submit" class="button button--inverse">投稿する</button>
        </div>
        </td>
        </div>
      </table>

    </form>
  </div>
</template>

<script>
import { CREATED, UNPROCESSABLE_ENTITY } from '../util'
import Loader from './Loader.vue'
export default {
  components: {
    Loader
  },
  props: {
    value: {

      type: Boolean,
      required: true,

    }
  },
  data () {
    return {
      loading: false,
      preview: null,
      photo: null,
      errors: null,
      writeForm: {
        file_name: '',
        productname_j: '',
        price: 0,
        selectedMajorid: '',
        selectedMiddleid: '',
        selectedSubcategoryid: '',
      },
    }
  },

  methods: {

    // フォームでファイルが選択されたら実行される
    onFileChange (event) {

      // 何も選択されていなかったら処理中断
      if (event.target.files.length === 0) {
        this.reset()
        return false
      }
      // ファイルが画像ではなかったら処理中断
      if (! event.target.files[0].type.match('image.*')) {
        this.reset()
        return false
      }
      // FileReaderクラスのインスタンスを取得
      const reader = new FileReader()
      // ファイルを読み込み終わったタイミングで実行する処理
      reader.onload = e => {
        // previewに読み込み結果（データURL）を代入する
        // previewに値が入ると<output>につけたv-ifがtrueと判定される
        // また<output>内部の<img>のsrc属性はpreviewの値を参照しているので
        // 結果として画像が表示される
        this.preview = e.target.result
      }
      // ファイルを読み込む
      // 読み込まれたファイルはデータURL形式で受け取れる（上記onload参照）
      reader.readAsDataURL(event.target.files[0])
      this.photo = event.target.files[0]

      this.writeForm.file_name = this.photo.name

    },
    // 入力欄の値とプレビュー表示をクリアするメソッド
    reset () {
      this.preview = ''
      this.photo = null
      this.$el.querySelector('input[type="file"]').value = null
      this.writeForm.file_name = ''
      this.writeForm.productname_j = ''
      this.writeForm.price = 0
      this.selectedMajorid = ''
      this.selectedMiddleid = ''
      this.selectedSubcategoryid = ''
    },
    async submit () {
      this.loading = true

      const formData = new FormData()
      formData.append('photo', this.photo)
  
      if (this.writeForm.file_name !== '') {
          this.writeForm.selectedMajorid = this.$store.getters['auth/selectedMajorid']
          this.writeForm.selectedMiddleid = this.$store.getters['auth/selectedMiddleid']
          this.writeForm.selectedSubcategoryid = this.$store.getters['auth/selectedSubcategoryid']
          formData.append('fphoto', this.writeForm.file_name)
          formData.append('jphoto', this.writeForm.productname_j)
          formData.append('price', this.writeForm.price)
          formData.append('majorid', this.writeForm.selectedMajorid)
          formData.append('middleid', this.writeForm.selectedMiddleid)
          formData.append('subcategoryid', this.writeForm.selectedSubcategoryid)

      }
      const response = await axios.post('./api/photos', formData)
      this.loading = false
      if (response.status === UNPROCESSABLE_ENTITY) {
        this.errors = response.data.errors
        return false
      }
      this.reset()
      this.$emit('input', false)
      if (response.status !== CREATED) {
        this.$store.commit('error/setCode', response.status)
        return false
      }
      // メッセージ登録
      this.$store.commit('message/setContent', {
        content: '写真が投稿されました！',
        timeout: 6000
      })
      //??? this.$router.push(`./`)
      this.$router.push(`./photos/${response.data.id}`)
    }
  }
}
</script>

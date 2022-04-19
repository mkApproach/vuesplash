<template>
  <div>
    <header>
      <Navbar />
    </header>
    <main>
      <sidebar class="sidebar-area"></sidebar>
      <div class="scafold-wrapper text-center">
        <div class="container">
          <Message /> <!-- ★ 追加 -->
          <RouterView />
        </div>
      </div>
    </main>
    <Footer />
  </div>
</template>

<script>
import Message from './components/Message.vue'
import Navbar from './components/Navbar.vue'
import Footer from './components/Footer.vue'
import Sidebar from './components/Sidebar.vue'

import { NOT_FOUND, UNAUTHORIZED, INTERNAL_SERVER_ERROR } from './util'

export default {
  components: {
    Message,
    Navbar,
    Sidebar,
    Footer
  },
  computed: {
    errorCode () {
      return this.$store.state.error.code
    }
  },
  watch: {
    errorCode: {
      async handler (val) {
        if (val === INTERNAL_SERVER_ERROR) {
          this.$router.push('/500')
        } else if (val === UNAUTHORIZED) {
          // トークンをリフレッシュ
          await axios.get('/api/refresh-token')
          // ストアのuserをクリア
          this.$store.commit('auth/setUser', null)
          // ログイン画面へ
          this.$router.push('/login')
        } else if (val === NOT_FOUND) {
          this.$router.push('/not-found')
        }
      },
      immediate: true
    },
    $route () {
      this.$store.commit('error/setCode', null)
    }
  }
}
</script>

<style scoped>
.sidebar-area {
  margin-top: 0px;
  /* 左側に固定 */
  float: left;
}

.footer-area {
  margin-top: 40px;
}

.scafold-wrapper {
  /* display: flex; 要素を横並びにする */
  flex-direction: column; /* 要素の並び順の主軸を指定 上 => 下 */
  min-height: 100vh; /* 要素の高さの最小値を指定 vhはviewport(表示領域) heightの略 */

  /* サイドバーのwidth分だけ範囲を削除 */
  width: calc(100% - 200px);

  /* サイドバーで隠れるので右に寄せる */
  margin: 0 0 0 180px;
}
</style>


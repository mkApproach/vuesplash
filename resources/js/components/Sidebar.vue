<template>
    <div class="sidebar">
        <div class="sidebar-wrapper">
            <div class="sidebar-link-area">
                <!-- サイドバーメニュー -->
                <p><router-link to="/counselings" class="sidebar-link">野　球</router-link></p>
                <p><router-link to="/expenses" class="sidebar-link">マラソン</router-link></p>
                <p><router-link to="/problems" class="sidebar-link">フットサル</router-link></p>
                <p><router-link to="/calendars" class="sidebar-link">バスケットボール</router-link></p>
                <p><router-link to="/admins" class="sidebar-link">ダーツ</router-link></p>
                <p><router-link to="/users" class="sidebar-link">マスク</router-link></p>              
            </div>    
        </div>

        <div class="sidebar-select">
            <p>
            <select v-model="selectedKey" v-on:change="selected">
                    <option v-for="(value, key) in items">
                        {{ key }}
                    </option>
            </select>
           
            <p>
            <select>
                <option v-if="selectedItem" v-for="item in selectedItem">
                    {{ item.name }}
                </option>
            </select>  
             </p>
        </div>


    </div>
</template>

<script>
export default {
    data: function() {
        return {
            selectid: '',
            selectedKey: '',
            selectedItem: '',
            items: {
                ユニフォーム: [
                    { name: '野　球' },
                    { name: 'Prius' },
                    { name: 'Collora' },
                    { name: 'Vitz' },
                    { name: 'Crown' },
                ],
                衛生品: [
                    { name: 'マスク' },
                    { name: 'Freed' },
                    { name: 'VEZEL' },
                    { name: 'N-WGN' },
                    { name: 'Fit' },
                ],
            }
        }
    },
    methods:{
        selected: function(){
            this.selectedItem = this.items[this.selectedKey];
        }
    }
}
</script>

<style>
.sidebar {
  background-color: #191970;
  height: 100%; /* サイドバーの高さ */
  width: 200px; /* サイドバーのwidthを指定 */
  max-width: 200px; /* widthの最大値 */
  opacity: 0.9.5; /* 透過する 0に近くほど透過する */
  position: fixed; /* 左上に要素を固定する(スクロールしても位置は固定される) */
  overflow-x: hidden; /* 横軸ではみ出た要素を非表示にする */
  box-sizing: border-box; /* paddingとborderを、widthとheightに含める */
  padding-left: 40px; /* サイドバー内のリンクの位置を右にずらす */
}

.sidebar-link-area {
  font-size: large;

  padding-top: 20px; /* サイドバーリンクの上部に空白を作る */
}

.sidebar-select {
  font-size: large;

  padding-top: 20px; /* サイドバーリンクの上部に空白を作る */
}

.sidebar-link {
  color: #ffffff; /* リンクの文字色を白に */
}

.sidebar-link:hover {
  color: #ffffff /* マウスがリンクに乗った時も文字色を白に */
}
</style>
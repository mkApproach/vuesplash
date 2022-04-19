/////////////////////////////////////////////////
//                                             //
//              Photo.vue                      //
//                                             //
//     写真フォーム （初期一覧表画面の一枚分）　      //
//                                             //
//                                             //
/////////////////////////////////////////////////
<template>
  <div class="photo">
    <figure class="photo__wrapper">
      <img
        class="photo__image"
        :src="item.url"
        :alt="`Photo by ${item.owner.name} ${item.url}`"
      >
    </figure>
    <RouterLink
      class="photo__overlay"
      :to="`./photos/${item.id}`"
      :title="`View the photo by ${item.owner.name}`"
    >
      <div class="photo__controls">

        <button
          class="photo__action photo__action--like"
          :class="{ 'photo__action--liked': item.liked_by_user }"
          title="評価する"
          @click.prevent="like"
        >
          <i class="icon ion-md-heart"></i>{{ item.likes_count }}
        </button>
        
        <button
          class="photo__action photo__action--remove"
          :class="{ 'photo__action--removed': item.liked_by_user }"
          title="削除する"
          @click.prevent="remove"
        >
          <i class="icon ion-md-trash"></i>
        </button>
        
        <a
          class="photo__action"
          title="Download"
          @click.stop
          :href="`/photos/${item.id}/download`"
        >
          <i class="icon ion-md-arrow-round-down"></i>
        </a>
      </div>
      <div class="photo__username">
        {{ item.owner.name }}
      </div>
    </RouterLink>
  </div>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      required: true
    }
  },
  methods: {
    like () {
      this.$emit('like', {
        id: this.item.id,
        liked: this.item.liked_by_user
      })
    },
    remove () {
      this.$emit('remove', {
        id: this.item.id,
        liked: this.item.liked_by_user
      })
    },    
  }
}
</script>
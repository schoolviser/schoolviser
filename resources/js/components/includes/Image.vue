<template>
 <img :src="" alt="">
</template>

<script>
export default {
 name : 'Image',
 data(){
  return {
    image : document.querySelector("meta[name='base-url']").getAttribute('content') + image
  }
 }
}
</script>
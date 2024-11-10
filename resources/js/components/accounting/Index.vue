<template>
<div class="py-2">
   <router-link :to="{name : 'accounting'}" class="me-2">Accounting</router-link>
   <router-link :to="{name : 'accounting.bills'}" class="me-2">bills</router-link>
</div>
 <router-view />

</template>
 
<script>

export default {
   name: 'AccountingIndex',

   data(){
      return {
         bills : Array()
      }
   }

}
</script>
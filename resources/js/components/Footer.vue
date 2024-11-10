<template>
 <footer class="footer">
   <div class="container text-center">
     <!-- Copyrights-->
     <div class="copyrights">
       <!-- Social menu-->
       <ul class="social list-inline-item">
        <li>{{ hello }}</li>
         <li class="list-inline-item"><a href="#" @click="handleEvent" target="_blank" class="social-link"><i class="mdi mdi-facebook"></i></a></li>
         <li class="list-inline-item"><a href="#" target="_blank" class="social-link"><i class="mid mdi-whatsapp"></i></a></li>
         <li class="list-inline-item"><a href="#" target="_blank" class="social-link"><i class="mdi mdi-linkedin"></i></a></li>
       </ul>
       <p class="copyrights-text mb-0">Copyright &copy; 2023 All rights reserved — Designed & Developed by <a href="https://stephenokello.com" target="_blank" class="copyrights-link">Stephen Okello</a></p>
     </div>
   </div>
 </footer>
</template>

<script>

export default {
   name: 'Footer',

   data() {
    return {
      hello : ''
    }
   },

   created(){
   },

   methods : {
    handleEvent(e){
      e.preventDefault();
     axios.get('/axios').then((response) => {
      this.hello = response.data;
     })
    }

   }
}
</script>
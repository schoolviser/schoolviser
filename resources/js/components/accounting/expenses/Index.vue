<template>
<div class="row">
   <div class="col-lg-7">
     <div class="table-responsive">
      <table class="table table-striped table-bordered">
            <thead>
               <tr>
                  <th scope="col" style="width: 5%;;"><input type="checkbox" name="master" id=""></th>
                  <th scope="col">Description</th>
                  <th scope="col">Date</th>
                  <th scope="col">Amount</th>
               </tr>
            </thead>
            <tbody>
               <tr v-for="(expense, index) in expenses" :key="expense.id">
                  <td><input type="checkbox" name="" id=""></td>
                  <td>
                     <p class="m-0">{{ expense.description }}</p>
                     <small class="text-primary font-14">{{ expense.account.name }}</small>
                  </td>
                  <td>
                     <p class="m-0">{{ expense.date }}</p>
                     <small>Stephen Okello Omoding</small>
                  </td>
                  <td>
                     <p class="m-0 fw-bold">UGX 100,100,00</p>
                  </td>
               </tr>
            </tbody>
         </table>
     </div>
      
   </div>
</div>
</template>
 
<script>


export default {
   name: 'Expenses',

   components : {
       
     },

   data(){
      return {
         expenses : Array()
      }
   },

   created(){
      this.getBills();
   },

   methods : {
      async getBills(){
         await axios.get('/accounting/expenses').then((response) => {
            console.log(response);
            this.expenses = response.data.expenses;
         })
      }
   }

}
</script>
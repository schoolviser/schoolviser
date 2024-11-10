<template>
 <div>
  <!-- Modal trigger button -->
  <button
   type="button"
   class="btn btn-primary btn-lg"
   data-bs-toggle="modal"
   data-bs-target="#recordNewBillModal"
  >
   Launch
  </button>
  
  
 </div>

 <RecordNewBillModal />
</template>

<script>
import RecordNewBillModal from '../modals/RecordNewBillModal.vue';

export default {

 name : 'Bills',

 components : {
    RecordNewBillModal
}

}
</script>
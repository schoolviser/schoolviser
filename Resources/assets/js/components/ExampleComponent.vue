<template>
  <HeaderSection
    heading="Manage Expenses"
    :actions="[
      { label: 'Add Expense', to: '/expenses/create' },
      { label: 'Export', onClick: exportData }
    ]"
  />

  <div class="">
    <div class="row">
      <div class="col-lg-6">
        <h4>Total Students</h4>
        <h6>300</h6>
      </div>
      <div class="col-lg-6">hello</div>
      <div class="col-lg-6">hello</div>
      <div class="col-lg-6">
        <li>
          <router-link to="/accounting/expenses">
            <span class="fa fa-briefcase mr-2"></span> Settings
          </router-link>
        </li>
      </div>
    </div>
  </div>
</template>

<script>
import HeaderSection from './layouts/HeaderSection.vue';

export default {
  name: 'ExampleComponent',
  components: {
    HeaderSection,
  },
  methods: {
    exportData() {
      alert('Exporting data...');
    },
  },
};
</script>

<style scoped>
h1 {
  color: #42b983;
}
</style>

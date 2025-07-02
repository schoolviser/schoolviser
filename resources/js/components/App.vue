<template>
    <SideBar />

    <!-- Page Content  -->
    <div id="content" class="p-4">
        <router-view /> <!-- Renders current page -->
    </div>


</template>

<script>

import SideBar from "./layout/SideBar.vue";

export default {
    components: {
        SideBar,
    },
};
</script>

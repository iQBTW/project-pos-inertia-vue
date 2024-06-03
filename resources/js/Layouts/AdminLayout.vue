<script setup>
import Sidebar from '@/Components/Sidebar.vue';
import { onMounted } from "vue";
import { initFlowbite } from "flowbite";

onMounted(() => {
    initFlowbite();
});
</script>

<template>
        <Sidebar/>
        <div class="relative md:ml-0 l:ml-64 lg:ml-64 xl:ml-64">
            <slot/>
        </div>
</template>


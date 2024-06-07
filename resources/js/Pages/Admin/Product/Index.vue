<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, router, } from "@inertiajs/vue3";
import {
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
} from "flowbite-vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Searchbar from "@/Components/Searchbar.vue";
import Button from "primevue/button";
import { ref, watch } from "vue";

const props = defineProps({
    products: Object,
});
const emit = defineEmits(['search'])

const search = ref('');
const onSearch = () => {
    router.get(route('product.index'), {q: search.value}, {
            preserveState: true,
            replace: true
        });
}
watch(search, (value) => {
    emit('search', value)
});

</script>

<template>
    <Head title="Dashboard Product" />

    <AdminLayout>
        <!-- Header Section -->
        <Breadcrumb title="All Products">
            <div class="sm:flex">
                <!-- SearchBar -->
                <Searchbar @submit.prevent="onSearch">
                    <input
                    v-model="search"
                    type="text"
                    name="categoriesSearch"
                    id="categories-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 transition-all ease-in 3s"
                    placeholder="Search categories"
                />
                </Searchbar>
                <!-- Add Button -->
                <div class="flex items-center ml-auto space-x-2 sm:space-x-3">
                    <Button
                        label="show"
                        severity="success"
                        class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-black rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 transition-all ease-in 3s"
                    >
                        <svg
                            class="w-5 h-5 mr-2 -ml-1"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                        Add Product
                    </Button>
                </div>
            </div>
        </Breadcrumb>

        <div class="flex justify-center pt-2">
            <div class="w-full px-2">
                <fwb-table hoverable>
                    <fwb-table-head>
                        <fwb-table-head-cell>No</fwb-table-head-cell>
                        <fwb-table-head-cell>Name</fwb-table-head-cell>
                        <fwb-table-head-cell>Image</fwb-table-head-cell>
                        <fwb-table-head-cell>Stock</fwb-table-head-cell>
                        <fwb-table-head-cell>Price</fwb-table-head-cell>
                        <fwb-table-head-cell>Category</fwb-table-head-cell>
                        <fwb-table-head-cell>Action</fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row
                            v-for="(product, index) in products.data"
                            :key="index"
                        >
                            <fwb-table-cell>{{ index + 1 }}</fwb-table-cell>
                            <fwb-table-cell>{{ product.name }}</fwb-table-cell>
                            <fwb-table-cell>{{ product.image }}</fwb-table-cell>
                            <fwb-table-cell>{{ product.stock }}</fwb-table-cell>
                            <fwb-table-cell>{{ product.price }}</fwb-table-cell>
                            <fwb-table-cell>{{ product.category }}</fwb-table-cell>
                            <fwb-table-cell class="flex gap-2">
                                <Button class="transition-all ease-in 3s border border-yellow-300 hover:text-white hover:bg-yellow-300">
                                    <a href="#">Edit</a>
                                </Button>
                                <Button severity="danger" class="transition-all ease-in 3s border hover:text-white hover:bg-red-800">
                                    <a href="#">Delete</a>
                                </Button>
                            </fwb-table-cell>
                        </fwb-table-row>
                    </fwb-table-body>
                </fwb-table>
                <div class="flex items-center justify-center mt-2 gap-3">
                    <span class="text-sm text-gray-700 dark:text-gray-400">
                        Showing
                        <span
                            class="font-semibold text-gray-900 dark:text-white"
                            >1</span
                        >
                        to
                        <span
                            class="font-semibold text-gray-900 dark:text-white"
                            >{{ products.per_page }}</span
                        >
                        of
                        <span
                            class="font-semibold text-gray-900 dark:text-white"
                            >{{ products.total }}</span
                        >
                        Entries
                    </span>
                    <ul class="flex items-center -space-x-px h-10 text-base">
                        <li v-for="(item, index) in products.links" :key="index">
                            <a
                                href="#" @click="pageTo(item.url)"
                                :class="{'bg-primary-500 text-white transition-all ease-in 3s' : item.active}"
                                class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 border rounded-md border-gray-300 hover:bg-primary-500 hover:text-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white transition-all ease-in 3s"
                                v-html="item.label"></a
                            >
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

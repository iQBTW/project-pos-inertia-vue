<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, router, } from "@inertiajs/vue3";
import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
} from "flowbite-vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Searchbar from "@/Components/Searchbar.vue";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import Button from "primevue/button";
import { ref, reactive, watch } from "vue";

const props = defineProps({
    orders: Object,
});
const emit = defineEmits(['search'])

const search = ref('');
const onSearch = () => {
    router.get(route('order.index'), {q: search.value}, {
            preserveState: true,
            replace: true
        });
}
watch(search, (value) => {
    emit('search', value)
});

const showModal = ref(false);
</script>

<template>
    <Head title="Dashboard Order" />

    <AdminLayout>
        <!-- Header Section -->
        <Breadcrumb title="All Orders">
            <div class="sm:flex">
                <!-- SearchBar -->
                <Searchbar @submit.prevent="onSearch">
                    <input
                    v-model="search"
                    type="text"
                    name="ordersSearch"
                    id="orders-search"
                    class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 transition-all ease-in 3s"
                    placeholder="Search orders"
                />
                </Searchbar>
            </div>
        </Breadcrumb>

        <div class="flex justify-center pt-2 pb-2">
            <div class="w-full px-2">
                <fwb-table hoverable>
                    <fwb-table-head>
                        <fwb-table-head-cell>No</fwb-table-head-cell>
                        <fwb-table-head-cell>Invoice</fwb-table-head-cell>
                        <fwb-table-head-cell>Customer Name</fwb-table-head-cell>
                        <fwb-table-head-cell>Product</fwb-table-head-cell>
                        <fwb-table-head-cell>Quantity</fwb-table-head-cell>
                        <fwb-table-head-cell>Total to Pay</fwb-table-head-cell>
                        <fwb-table-head-cell>Received Amount</fwb-table-head-cell>
                        <fwb-table-head-cell>Action</fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row
                            v-for="(order, index) in orders.data"
                            :key="index"
                        >
                            <fwb-table-cell>{{ index + 1 }}</fwb-table-cell>
                            <fwb-table-cell>{{ order.invoice }}</fwb-table-cell>
                            <fwb-table-cell>{{ order.customer }}</fwb-table-cell>
                            <fwb-table-cell>{{ order.product }}</fwb-table-cell>
                            <fwb-table-cell>{{ order.qty }}</fwb-table-cell>
                            <fwb-table-cell>{{ order.total }}</fwb-table-cell>
                            <fwb-table-cell>{{ order.amount }}</fwb-table-cell>
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
                <div class="flex items-center justify-between mt-2 gap-3">
                    <span class="text-sm text-gray-700 dark:text-gray-400">
                        Showing
                        <span
                            class="font-semibold text-gray-900 dark:text-white"
                            >1</span
                        >
                        to
                        <span
                            class="font-semibold text-gray-900 dark:text-white"
                            >{{ orders.per_page }}</span
                        >
                        of
                        <span
                            class="font-semibold text-gray-900 dark:text-white"
                            >{{ orders.total }}</span
                        >
                        Entries
                    </span>
                    <ul class="flex items-center -space-x-px h-10 text-base">
                        <li v-for="(item,index) in orders.links" :key="index">
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

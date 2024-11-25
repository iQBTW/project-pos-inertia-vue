<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, router, Link } from "@inertiajs/vue3";
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
import { ref, watch, inject } from "vue";

const props = defineProps({
    orders: Array,
});

const Swal = inject("$swal");

const emit = defineEmits(["search"]);

// Searchbar
const search = ref("");
const onSearch = () => {
    router.get(
        route("order.index"),
        { q: search.value },
        {
            preserveState: true,
            replace: true,
        }
    );
};
watch(search, (value) => {
    emit("search", value);
});

// Pagination
const pageTo = (url) => {
    router.get(url);
};

// Edit
const editOrder = (id) => {
    router.get("/dashboard/order" + "/" + id + "/edit");
};

//Delete
const deleteOrder = (id) => {
    router.delete("/dashboard/order/" + id, {
        onSuccess: (success) => {
            console.log(success);
            Swal.fire({
                toast: true,
                icon: "success",
                position: "top-end",
                title: "Order Deleted Successfully",
                showConfirmButton: false,
                timer: 2000,
            });
        },
        onError: (error) => {
            console.log(error);
            Swal.fire({
                toast: true,
                icon: "error",
                position: "top-end",
                title: "There was an error",
                showConfirmButton: false,
                timer: 2000,
            });
        },
    });
};
</script>

<template>
    <Head title="Dashboard Order" />

    <AdminLayout>
        <!-- Header Section -->
        <Breadcrumb title="All Orders">
            <template #breadcrumb>
                <li class="inline-flex items-center">
                    <Link
                        :href="route('dashboard')"
                        class="inline-flex items-center text-gray-700 hover:text-primary-600 dark:text-gray-300 dark:hover:text-white"
                    >
                        <svg
                            class="w-5 h-5 mr-2.5"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"
                            ></path>
                        </svg>
                        Home
                    </Link>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg
                            class="w-6 h-6 text-gray-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                        <Link
                            :href="route('order.index')"
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white"
                            >Orders</Link
                        >
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg
                            class="w-6 h-6 text-gray-400"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                        <span
                            class="ml-1 text-gray-400 md:ml-2 dark:text-gray-500"
                            aria-current="page"
                            >List</span
                        >
                    </div>
                </li>
            </template>
            <template #search>
                <div class="sm:flex">
                    <Searchbar @submit.prevent="onSearch">
                        <input
                            v-model="search"
                            type="text"
                            name="categoriesSearch"
                            id="categories-search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 transition-all ease-in 3s"
                            placeholder="Search orders"
                        />
                    </Searchbar>
                    <div
                        class="flex items-center ml-auto space-x-2 sm:space-x-3"
                    ></div>
                </div>
            </template>
        </Breadcrumb>

        <div class="flex justify-center pt-2 pb-2">
            <div class="w-full px-2">
                <fwb-table hoverable>
                    <fwb-table-head>
                        <fwb-table-head-cell>No</fwb-table-head-cell>
                        <fwb-table-head-cell>Invoice</fwb-table-head-cell>
                        <fwb-table-head-cell>Customer Name</fwb-table-head-cell>
                        <fwb-table-head-cell>Quantity</fwb-table-head-cell>
                        <fwb-table-head-cell>Total to Pay</fwb-table-head-cell>
                        <fwb-table-head-cell>Received Amount</fwb-table-head-cell>
                        <fwb-table-head-cell>Status</fwb-table-head-cell>
                        <fwb-table-head-cell>Action</fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row
                            v-for="(order, index) in orders.data"
                            :key="index"
                        >
                            <fwb-table-cell>{{ index + 1 }}</fwb-table-cell>
                            <fwb-table-cell>{{ order.invoice }}</fwb-table-cell>
                            <fwb-table-cell>{{ order.order_details.user.name }}</fwb-table-cell>
                            <fwb-table-cell>{{ order.qty }}</fwb-table-cell>
                            <fwb-table-cell>{{ order.total }}</fwb-table-cell>
                            <fwb-table-cell>{{ order.amount }}</fwb-table-cell>
                            <fwb-table-cell>{{ order.status }}</fwb-table-cell>
                            <fwb-table-cell class="flex gap-2">
                                <Button
                                    class="transition-all ease-in 3s border border-yellow-300 hover:text-white hover:bg-yellow-300"
                                >

                                    <a @click.prevent="editOrder(order.id)">Edit</a>
                                </Button>
                                <Button
                                    severity="danger"
                                    class="transition-all ease-in 3s border hover:text-white hover:bg-red-800"
                                >
                                    <a @click.prevent="deleteOrder(order.id)">Delete</a>
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
                        <li v-for="(item, index) in orders.links" :key="index">
                            <a
                                href="#"
                                @click="pageTo(item.url)"
                                :class="{
                                    'bg-primary-500 text-white transition-all ease-in 3s':
                                        item.active,
                                }"
                                class="flex items-center justify-center px-4 h-10 leading-tight text-gray-500 border rounded-md border-gray-300 hover:bg-primary-500 hover:text-white dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white transition-all ease-in 3s"
                                v-html="item.label"
                            ></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

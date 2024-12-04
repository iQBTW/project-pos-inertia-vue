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
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import { ref, watch, inject, reactive } from "vue";

const props = defineProps({
    orders: Array,
});

const Swal = inject("$swal");

const form = reactive({
    id: null,
    invoice: null,
})

const showModal = ref(false);

// Searchbar
const emit = defineEmits(["search"]);
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

// Delete Modal
const openDeleteModal = (order, index) => {
    showModal.value = true;
    form.id = order.id;
    form.name = order.name;
}
const confirmDelete = () => {
    deleteOrder(form.id);
    showModal.value = false;
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

        <div class="pt-2 pb-2">
            <div class="w-full px-2 bg-gray-300/50 min-h-screen pt-2">
                <fwb-table hoverable>
                    <fwb-table-head>
                        <fwb-table-head-cell class="text-center">No</fwb-table-head-cell>
                        <fwb-table-head-cell class="text-center">Invoice</fwb-table-head-cell>
                        <fwb-table-head-cell class="text-center">Customer Name</fwb-table-head-cell>
                        <fwb-table-head-cell class="text-center">Total to Pay</fwb-table-head-cell>
                        <fwb-table-head-cell class="text-center">Received Amount</fwb-table-head-cell>
                        <fwb-table-head-cell class="text-center">Status</fwb-table-head-cell>
                        <fwb-table-head-cell class="text-center">Action</fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row
                            v-for="(order, index) in orders.data"
                            :key="index"
                        >
                            <fwb-table-cell class="text-center">{{ index + 1 }}</fwb-table-cell>
                            <fwb-table-cell class="text-center">{{ order.invoice }}</fwb-table-cell>
                            <fwb-table-cell class="text-center">{{ order.order_details?.user.name ? order.order_details.user.name : 'N/A' }}</fwb-table-cell>
                            <fwb-table-cell class="text-center">{{ order.total }}</fwb-table-cell>
                            <fwb-table-cell class="text-center">{{ order.amount }}</fwb-table-cell>
                            <fwb-table-cell class="text-center">{{ order.status }}</fwb-table-cell>
                            <fwb-table-cell class="flex items-center justify-center">
                                <Button
                                    class="transition-all ease-in 3s border-0 hover:text-yellow-300"
                                    @click="editOrder(order.id)"
                                >

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </Button>
                                <Button
                                    class="transition-all ease-in 3s border-0 hover:text-red-800"
                                    @click="openDeleteModal(order, index)"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
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

        <Dialog
            class="bg-white"
            v-model:visible="showModal"
            modal
            header="Delete Order"
            :style="{ width: '25rem' }"
        >
            <form @submit.prevent="confirmDelete()">
                <span
                    class="text-surface-600 dark:text-surface-0/70 block mb-5"
                    >Delete an existing Order</span
                >

                <div class="pb-2">
                    <p>Are you sure you want to delete this <b>{{ form.invoice }}</b> Order?</p>
                </div>

                <div class="flex justify-end gap-2">
                    <Button
                        type="button"
                        label="Cancel"
                        severity="danger"
                        class="hover:bg-red-700 transition-all ease-in 3s"
                        @click="showModal = false"
                    ></Button>
                    <Button
                        type="submit"
                        class="hover:bg-red-700 transition-all ease-in 3s"
                        severity="warning"
                        label="Delete"
                    ></Button>
                </div>
            </form>
        </Dialog>
    </AdminLayout>
</template>

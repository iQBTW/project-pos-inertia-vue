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
    categories: Object,
});
const emit = defineEmits(['search'])

const search = ref('');
const onSearch = () => {
    router.get(route('dashboard.category'), {q: search.value}, {
            preserveState: true,
            replace: true
        });
}
watch(search, (value) => {
    emit('search', value)
    console.log(value);
});

const showModal = ref(false);

const formCategory = reactive({
    name: null,
});
function storeCategory() {
    router.post("/dashboard/category", formCategory).then(() => {
        showModal.value = false;
        formProject.name = null;
    });
}
</script>

<template>
    <Head title="Dashboard Category" />

    <AdminLayout>
        <!-- Header Section -->
        <Breadcrumb title="All Categories">
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
                        @click="showModal = true"
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
                        Add Category
                    </Button>
                    <Dialog
                        class="bg-white"
                        v-model:visible="showModal"
                        modal
                        header="Create Category"
                        :style="{ width: '25rem'}"
                    >
                        <form @submit.prevent="storeCategory">
                            <span
                                class="text-surface-600 dark:text-surface-0/70 block mb-5"
                                >Create a new category.</span
                            >
                            <div class="flex items-center gap-3 mb-3">
                                <div class="">
                                    <label for="name" class="font-semibold w-[6rem]"
                                        >Category Name</label
                                    >
                                </div>
                                <InputText
                                    id="name"
                                    v-model="formCategory.name"
                                    class="flex-auto border-0 ring-1 ring-bg-primary-500 focus:ring-1 focus:ring-primary-500"
                                    autocomplete="off"
                                />
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
                                    class="hover:bg-green-700 transition-all ease-in 3s"
                                    severity="success"
                                    label="Save"
                                ></Button>
                            </div>
                        </form>
                    </Dialog>
                </div>
            </div>
        </Breadcrumb>

        <div class="flex justify-center pt-2">
            <div class="w-full px-2">
                <fwb-table hoverable>
                    <fwb-table-head>
                        <fwb-table-head-cell>No</fwb-table-head-cell>
                        <fwb-table-head-cell>Name</fwb-table-head-cell>
                        <fwb-table-head-cell>Action</fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row
                            v-for="(category, index) in categories"
                            :key="category.id"
                        >
                            <fwb-table-cell>{{ index + 1 }}</fwb-table-cell>
                            <fwb-table-cell>{{ category.name }}</fwb-table-cell>
                            <fwb-table-cell class="flex gap-2">
                                <Button severity="warning">
                                    <fwb-a
                                        href="#"
                                    >
                                        Edit
                                    </fwb-a>
                                </Button>
                                <Button severity="danger">
                                <fwb-a href="#"> Delete </fwb-a>
                                </Button>
                            </fwb-table-cell>
                        </fwb-table-row>
                    </fwb-table-body>
                </fwb-table>
            </div>
        </div>
    </AdminLayout>
</template>

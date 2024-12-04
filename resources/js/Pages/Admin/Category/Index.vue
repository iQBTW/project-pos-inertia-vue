<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { inject } from "vue";
import { Head, router, Link } from "@inertiajs/vue3";
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

const Swal = inject('$swal')

const props = defineProps({
    categories: Object,
});

const formCategory = reactive({
    id: null,
    name: null,
});

const isEdit = ref(false);
const isDelete = ref(false);
const showModal = ref(false);

const emit = defineEmits(["search"]);

// Searchbar
const search = ref("");
const onSearch = () => {
    router.get(
        route("category.index"),
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

//Create Modal
const openCreateModal = () => {
    isEdit.value = false;
    isDelete.value = false;
    showModal.value = true;

    formCategory.name = null;
}

//Edit Modal
const openEditModal = (category, index) => {
    isEdit.value = true;
    isDelete.value = false;
    showModal.value = true;

    formCategory.name = category.name;
    formCategory.id = category.id;
};

//Delete Modal
const openDeleteModal = (category, index) => {
    isEdit.value = false;
    isDelete.value = true;
    showModal.value = true;

    formCategory.name = category.name;
    formCategory.id  = category.id
}

const confirmDelete = () => {
    deleteCategory(formCategory.id);
    showModal.value = false;
}

//Create
const storeCategory = () => {
    try {
        router.post(route("category.store"), formCategory, {
            onSuccess: () => {
                Swal.fire({
                    toast: true,
                    icon: "success",
                    position: "top-end",
                    title: "Category Created Successfully",
                    showConfirmButton: false,
                    timer: 2000
                })
                showModal.value = false;
                formCategory.name = null;
            },
            onError: (errors) => {
                console.log(errors);
                Swal.fire({
                    toast: true,
                    icon: "error",
                    position: "top-end",
                    title: "There was an error",
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        });
    } catch (e) {
        console.log(e);
    }
}

//Edit
const updateCategory = async () => {
    try {
        router.put(`/dashboard/category/${formCategory.id}`, formCategory, {
            onSuccess: () => {
                Swal.fire({
                    toast: true,
                    icon: "success",
                    position: "top-end",
                    title: "Category Updated Successfully",
                    showConfirmButton: false,
                    timer: 2000
                })
                showModal.value = false;
                formCategory.name = null;
            },
            onError: (errors) => {
                console.log(errors);
                Swal.fire({
                    toast: true,
                    icon: "error",
                    position: "top-end",
                    title: "There was an error",
                    showConfirmButton: false,
                    timer: 2000
                })
            }
        })
    } catch (e){
        console.log(e);
    }
}

//Delete
const deleteCategory = (id) => {
    router.delete('/dashboard/category/' + id, {
        onSuccess: () => {
            Swal.fire({
                toast: true,
                icon: "success",
                position: "top-end",
                title: "Category Deleted Successfully",
                showConfirmButton: false,
                timer: 2000
            })
        },
        onError: (errors) => {
            console.log(errors);
            Swal.fire({
                toast: true,
                icon: "error",
                position: "top-end",
                title: "There was an error",
                showConfirmButton: false,
                timer: 2000
            })
        }
    })
}
</script>

<template>
    <Head title="Dashboard Category" />

    <AdminLayout>
        <!-- Header Section -->
        <Breadcrumb title="All Categories">
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
                            :href="route('category.index')"
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white"
                            >Categories</Link
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
                            placeholder="Search categories"
                        />
                    </Searchbar>
                    <div
                        class="flex items-center ml-auto space-x-2 sm:space-x-3"
                    >
                        <Button
                            label="show"
                            @click="openCreateModal"
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
                    </div>
                </div>
            </template>
        </Breadcrumb>

        <div class="pt-2 pb-2">
            <div class="w-full px-2 bg-gray-300/50 min-h-screen pt-2">
                <fwb-table hoverable>
                    <fwb-table-head>
                        <fwb-table-head-cell class="text-center">No</fwb-table-head-cell>
                        <fwb-table-head-cell class="text-center">Name</fwb-table-head-cell>
                        <fwb-table-head-cell class="text-center">Action</fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row
                            v-for="(category, index) in categories.data"
                            :key="category.id"
                        >
                            <fwb-table-cell class="text-center">{{ index + 1 }}</fwb-table-cell>
                            <fwb-table-cell class="text-center">{{ category.name }}</fwb-table-cell>
                            <fwb-table-cell class="flex items-center justify-center">
                                <Button
                                    class="transition-all ease-in 3s border-0 hover:text-yellow-300"
                                    @click="openEditModal(category, index)"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>
                                </Button>
                                <Button
                                    class="transition-all ease-in 3s border-0 hover:text-red-800"
                                    @click.prevent="openDeleteModal(category, index)"
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
                            >{{ categories.per_page }}</span
                        >
                        of
                        <span
                            class="font-semibold text-gray-900 dark:text-white"
                            >{{ categories.total }}</span
                        >
                        Entries
                    </span>
                    <ul class="flex items-center -space-x-px h-10 text-base">
                        <li
                            v-for="(item, index) in categories.links"
                            :key="index"
                        >
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
            :header="isEdit ? 'Edit Category' : isDelete ? 'Delete Category' : 'Create Category'"
            :style="{ width: '25rem' }"
        >
            <form @submit.prevent="isEdit ? updateCategory() : isDelete ? confirmDelete() : storeCategory()">
                <span
                    class="text-surface-600 dark:text-surface-0/70 block mb-5"
                    >{{ isEdit ? 'Edit an existing Category' : isDelete ? 'Delete an existing Category' : 'Create a new Category' }}</span
                >

                <div v-if="!isDelete" class="flex items-center gap-3 mb-3">
                    <div class="">
                        <label
                            for="name"
                            class="font-semibold w-[6rem]"
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

                <div v-if="isDelete" class="">
                    <p>Are you sure you want to delete <b>{{ formCategory.name }}</b> category?</p>
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
                        :class="isEdit ? 'hover:bg-green-700 transition-all ease-in 3s' : isDelete ? 'hover:bg-red-700 transition-all ease-in 3s' : 'hover:bg-green-700 transition-all ease-in 3s'"
                        :severity="isEdit ? 'success' : isDelete ? 'warning' : 'success'"
                        :label="isEdit ? 'Submit' : isDelete ? 'Delete' : 'Submit'"
                    ></Button>
                </div>
            </form>
        </Dialog>
    </AdminLayout>
</template>

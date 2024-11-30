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
    productCategories: Object,
    products: Object,
    categories: Object,
});

const form = reactive({
    id: null,
    product_id: null,
    category_id: null,
});

const isEdit = ref(false);
const showModal = ref(false);

const emit = defineEmits(["search"]);

// Searchbar
const search = ref("");
const onSearch = () => {
    router.get(
        route("product_categories.index"),
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

// Create Modal
const openCreateModal = () => {
    isEdit.value = false;
    showModal.value = true;

    form.product_id = null;
    form.category_id = null;
}

// Edit Modal
const openEditModal = (productCategory, index) => {
    isEdit.value = true;
    showModal.value = true;

    form.id = productCategory.id;
    form.product_id = productCategory.product_id;
    form.category_id = productCategory.category_id;
};

//Create
const storeCategory = () => {
    try {
        router.post(route("product_category.store"), form, {
            onSuccess: () => {
                Swal.fire({
                    toast: true,
                    icon: "success",
                    position: "top-end",
                    title: "Product Category Created Successfully",
                    showConfirmButton: false,
                    timer: 2000
                })
                showModal.value = false;
                form.product_id = null;
                form.category_id = null;
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
    <Head title="Dashboard Product Category" />

    <AdminLayout>
        <!-- Header Section -->
        <Breadcrumb title="All Product Categories">
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
                            :href="route('product_category.index')"
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white"
                            >Product Categories</Link
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
                            name="productCategoriesSearch"
                            id="productCategories-search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 transition-all ease-in 3s"
                            placeholder="Search Product Categories"
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
                            Add Product Category
                        </Button>
                        <Dialog
                            class="bg-white"
                            v-model:visible="showModal"
                            modal
                            :header="isEdit ? 'Edit Product Category' : 'Create Product Category'"
                            :style="{ width: '25rem' }"
                        >
                            <form @submit.prevent="isEdit ? updateCategory() : storeCategory()">
                                <span
                                    class="text-surface-600 dark:text-surface-0/70 block mb-5"
                                    >{{ isEdit ? 'Edit an existing Product Category' : 'Create a new Product Category' }}</span
                                >
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="">
                                        <label
                                            for="product"
                                            class="font-semibold w-[6rem]"
                                            >Product</label
                                        >
                                    </div>
                                    <select
                                        name="product_id"
                                        class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                                        id=""
                                        v-model="form.product_id"
                                    >
                                        <option value="" selected>Product</option>
                                        <option
                                            v-for="product in products"
                                            :key="product.id"
                                            :value="product.id"
                                        >
                                            {{ product.name }}
                                        </option>
                                    </select>
                                </div>
                                <div class="flex items-center gap-3 mb-3">
                                    <div class="">
                                        <label
                                            for="product"
                                            class="font-semibold w-[6rem]"
                                            >Category</label
                                        >
                                    </div>
                                    <select
                                        name="category_id"
                                        class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                                        id=""
                                        v-model="form.category_id"
                                    >
                                        <option value="" selected>Category</option>
                                        <option
                                            v-for="category in categories"
                                            :key="category.id"
                                            :value="category.id"
                                        >
                                            {{ category.name }}
                                        </option>
                                    </select>
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
            </template>
        </Breadcrumb>

        <div class="pt-2 pb-2">
            <div class="w-full px-2 bg-gray-300/50 min-h-screen pt-2">
                <fwb-table hoverable>
                    <fwb-table-head>
                        <fwb-table-head-cell>No</fwb-table-head-cell>
                        <fwb-table-head-cell>Product</fwb-table-head-cell>
                        <fwb-table-head-cell>Category</fwb-table-head-cell>
                        <fwb-table-head-cell>Action</fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row
                            v-for="(productCategory, index) in productCategories.data"
                            :key="productCategory.id"
                        >
                            <fwb-table-cell>{{ index + 1 }}</fwb-table-cell>
                            <fwb-table-cell>{{ productCategory.product }}</fwb-table-cell>
                            <fwb-table-cell>{{ productCategory.category }}</fwb-table-cell>
                            <fwb-table-cell class="flex gap-2">
                                <Button
                                    class="transition-all ease-in 3s border border-yellow-300 hover:text-white hover:bg-yellow-300"
                                    @click="openEditModal(productCategory, index)"
                                >
                                    Edit
                                </Button>
                                <Button
                                    severity="danger"
                                    class="transition-all ease-in 3s border hover:text-white hover:bg-red-800"
                                    @click.prevent="deleteCategory(productCategory.id)"
                                >
                                    Delete
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
                            >{{ productCategories.per_page }}</span
                        >
                        of
                        <span
                            class="font-semibold text-gray-900 dark:text-white"
                            >{{ productCategories.total }}</span
                        >
                        Entries
                    </span>
                    <ul class="flex items-center -space-x-px h-10 text-base">
                        <li
                            v-for="(item, index) in productCategories.links"
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
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { inject } from "vue";
import { Head, router, useForm, Link } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Button from "primevue/button";

const Swal = inject('$swal')

const props = defineProps({
    categories: Object,
});

const formProduct = useForm({
    name: null,
    stock: null,
    price: null,
    category_ids: [],
    images: [],
});

const onFileChange = (e) => {
    formProduct.images = Array.from(e.target.files);
}

const storeProduct = () => {
    const formData = new FormData();
    formData.append('name', formProduct.name);
    formData.append('stock', formProduct.stock);
    formData.append('price', formProduct.price);
    formProduct.category_ids.forEach((categoryId) => {
        formData.append("category_ids[]", categoryId);
    });
    for (let i = 0; i < formProduct.images.length; i++) {
        formData.append('images[]', formProduct.images[i]);
    }

    router.post(route("product.store"), formData, {
        onError: () => {
            Swal.fire({
                toast: true,
                icon: "error",
                position: "top-end",
                title: "There was an error",
                showConfirmButton: false,
                timer: 2000
            })
        },
        onSuccess: () => {
            Swal.fire({
                toast: true,
                icon: "success",
                position: "top-end",
                title: "Product Created Successfully",
                showConfirmButton: false,
                timer: 2000
            })
        }
    });
}
</script>

<template>
    <Head title="Dashboard Product" />

    <AdminLayout>
        <!-- Header Section -->
        <Breadcrumb title="Create New Product">
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
                            >Products</Link
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
                            >New Product</span
                        >
                    </div>
                </li>
            </template>
        </Breadcrumb>

        <!-- Content Section -->
        <div class="p-4 bg-white w-1/2 rounded-lg shadow-md mt-5 mb-5 mx-auto">
            <form @submit.prevent="storeProduct">
                <div class="flex flex-col items-center">
                    <div class="py-2">
                        <div class="py-2">
                            <label for="name">Product Name</label>
                        </div>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            v-model="formProduct.name"
                        />
                    </div>
                    <div class="">
                        <div class="py-2">
                            <label for="stock">Stock</label>
                        </div>
                        <input
                            type="number"
                            name="stock"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            id=""
                            v-model="formProduct.stock"
                        />
                    </div>
                    <div class="">
                        <div class="py-2">
                            <label for="price">Price</label>
                        </div>
                        <input
                            type="number"
                            name="price"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            id=""
                            v-model="formProduct.price"
                        />
                    </div>
                    <div class="w-[295px]">
                        <div class="py-2">
                            <label for="category">Category</label>
                        </div>
                        <div class="gap-4">
                            <div
                                v-for="category in categories"
                                :key="category.id"
                                class="flex items-center gap-2"
                            >
                                <input
                                    type="checkbox"
                                    class="w-4 h-4 rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 transition-all ease-in-out 3s"
                                    :id="`category-${category.id}`"
                                    :value="category.id"
                                    v-model="formProduct.category_ids"
                                />
                                <label :for="`category-${category.id}`">
                                    {{ category.name }}
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="py-2">
                        <div class="py-2">
                            <label for="Image">Image</label>
                        </div>
                        <input
                            type="file"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            name="images"
                            id=""
                            @change="onFileChange"
                            multiple
                        />
                    </div>
                    <div class="flex items-center ml-auto gap-3 pt-5">
                        <Button type="submit" severity="success">Submit</Button>
                        <Button type="button" severity="danger"
                            ><Link :href="route('product.index')"
                                >Cancel</Link
                            ></Button
                        >
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, router, useForm } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";

const props = defineProps({
    categories: Object,
});

const formProduct = useForm({
    name: null,
    stock: null,
    price: null,
    category_id: null,
    images: null
});

function onFileChange(e) {
    formProduct.images = e.target.files
}

function storeProduct() {
    router.post(route("product.store"), formProduct)
}
</script>

<template>
    <Head title="Dashboard Product" />

    <AdminLayout>
        <!-- Header Section -->
        <Breadcrumb title="Create New Products">

        </Breadcrumb>

        <!-- Content Section -->
        <div class="p-4">
            <form @submit.prevent="storeProduct">
                <input type="text" name="name" id="" v-model="formProduct.name">
                <input type="number" name="stock" id="" v-model="formProduct.stock">
                <input type="number" name="price" id="" v-model="formProduct.price">
                <select name="category_id" id="" v-model="formProduct.category_id">
                    <option value="">Category</option>
                    <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                </select>
                <input type="file" name="images" id="" @change="onFileChange" multiple>

                <button type="submit">Submit</button>
            </form>
        </div>
    </AdminLayout>
</template>

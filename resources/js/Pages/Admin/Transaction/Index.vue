<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, router, Link } from "@inertiajs/vue3";
// import Breadcrumb from "@/Components/Breadcrumb.vue";
// import Searchbar from "@/Components/Searchbar.vue";
// import Dialog from "primevue/dialog";
// import InputText from "primevue/inputtext";
import Button from "primevue/button";
// import { ref, reactive, watch } from "vue";

const props = defineProps({
    products: Object,
});

console.log(props.products);
</script>

<template>
    <Head title="Dashboard Shop" />

    <AdminLayout>
        <div class="flex justify-center pb-2 pt-5">
            <div class="px-2 bg-white rounded-md shadow-md pb-10">
                <h2 class="text-xl font-semibold text-white">Buy a Product</h2>
                <div class="flex items-center gap-2 px-5">
                    <div class="flex flex-col gap-2">
                        <label for="product">Product</label>
                        <select
                            name="product"
                            id="product"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                        >
                            <option value="">Pilih Product</option>
                            <option
                                :value="product.id"
                                :key="index"
                                v-for="(product, index) in products"
                            >
                                {{ product.name }}
                            </option>
                        </select>
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="quantity">Quantity</label>
                        <input
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            type="number"
                            name=""
                            id=""
                        />
                    </div>
                    <div
                        class="rounded-full px-[7px] pt-1 bg-blue-500 mt-[31px] hover:bg-blue-700 hover:shadow-lg hover:shadow-slate-300 transition-all ease-in-out 5s"
                    >
                        <button class="">
                            <svg
                                class="text-gray-800 dark:text-white"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                width="24"
                                height="24"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke="currentColor"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M5 12h14m-7 7V5"
                                />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="text-end mt-5 mr-16">
                    <Button severity="success">Order</Button>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

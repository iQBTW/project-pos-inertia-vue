<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { inject } from "vue";
import { Head, router, useForm, Link } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Button from "primevue/button";

const Swal = inject("$swal");

const props = defineProps({
    order: Object,
});

const form = useForm({
    amount: props.order.amount || 0,
});

const updateOrder = (id) => {
    const isValid = form.amount >= props.order.total;
    if (!isValid) {
        Swal.fire({
            toast: true,
            icon: "error",
            position: "top-end",
            title: 'Amount must be greater than or equal to total amount',
            showConfirmButton: false,
            timer: 2000,
        });
        return;
    }

    router.post(`/dashboard/order/${id}`, form, {
        onError: (error) => {
            console.log(error);
            Swal.fire({
                toast: true,
                icon: "error",
                position: "top-end",
                title: 'Something went wrong',
                showConfirmButton: false,
                timer: 2000,
            });
        },
        onSuccess: (success) => {
            console.log(success);
            Swal.fire({
                toast: true,
                icon: "success",
                position: "top-end",
                title: 'Order has been updated',
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
        <Breadcrumb title="Edit Order">
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
                            >Edit Order</span
                        >
                    </div>
                </li>
            </template>
        </Breadcrumb>

        <!-- Content Section -->
        <div class="p-4 bg-white w-[600px] rounded-lg shadow-md mt-5 mb-5 mx-auto">
            <form @submit.prevent="updateOrder(order.id)">
                <div class="flex flex-col">
                    <div class="text-right pr-2">
                        <label for="invoice" class="font-bold text-2xl">INVOICE</label>
                        <div class="flex justify-between items-center">
                            <div class="text-left">
                                <p class="font-bold text-sm">BILLED TO:</p>
                                <p class="font-light text-sm">{{ order.order_details.user.name }}</p>
                                <p class="font-light text-sm">{{ order.order_details.address }}</p>
                            </div>
                            <div class="">
                                <p class="font-bold text-sm">{{ order.status }}</p>
                                <p class="font-light text-sm">#{{ order.invoice }}</p>
                                <p class="font-light text-sm">{{ order.formatted_date }}</p>
                            </div>
                        </div>
                        <div class="mt-5">
                            <table class="w-full text-center">
                                <thead>
                                    <tr class="bg-slate-400">
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="border-black border-b-2" v-for="item in order.order_products" :key="item.id">
                                        <td>{{ item.product.name }}</td>
                                        <td>{{ item.qty_per_product }}</td>
                                        <td>{{ item.product.price }}</td>
                                        <td>{{ item.total_per_product }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="pt-5">
                                <div class="border-b-2 border-b-black">
                                    <p class="font-bold text-xl">Total {{ order.total }}</p>
                                </div>
                                <div class="pt-2">
                                    <p class="font-bold text-xl">Total Payed</p>
                                    <input type="text" class="text-center font-bold rounded border-0 w-[100px]" name="amount" v-model="form.amount">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center ml-auto gap-3 pt-5">
                        <Button type="submit" severity="success">Submit</Button>
                        <Button type="button" severity="danger">
                            <Link :href="route('order.index')">Cancel</Link>
                        </Button>
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

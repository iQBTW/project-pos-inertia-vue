<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { inject } from "vue";
import { Head, router, useForm, Link } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Button from "primevue/button";

const Swal = inject("$swal");

const props = defineProps({
    order: Object,
    products: Object,
    users: Object,
});

const formOrder = useForm({
    invoice: props.order.invoice || "",
    product_id: props.order.product_id || "",
    product: props.order.product || "",
    amount: props.order.amount || 0,
    status: props.order.status || "",
    qty: props.order.qty || 0,
    total: props.order.total || 0,
    user_id: props.order.user_id || "",
    user: props.order.user || "",
    order_detail_id: props.order.order_detail_id || 0,
});

const updateOrder = (id) => {
    const formData = new FormData();
    formData.append("invoice", formOrder.invoice);
    formData.append("product_id", formOrder.product_id);
    formData.append("amount", formOrder.amount);
    formData.append("status", formOrder.status);
    formData.append("qty", formOrder.qty);
    formData.append("total", formOrder.total);
    formData.append("user_id", formOrder.user_id);
    formData.append("order_detail_id", formOrder.order_detail_id);
    formData.append("_method", "PUT");

    console.log("FormData:", {
        invoice: formOrder.invoice,
        product_id: formOrder.product_id,
        amount: formOrder.amount,
        status: formOrder.status,
        qty: formOrder.qty,
        total: formOrder.total,
        user_id: formOrder.user_id,
        order_detail_id: formOrder.order_detail_id,
    });

    router.post(`/dashboard/order/${id}`, formData, {
        onError: (err) => {
            console.log(err);
            Swal.fire({
                toast: true,
                icon: "error",
                position: "top-end",
                title: "There was an error",
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
                title: "Product Updated Successfully",
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
            <form @submit.prevent="updateProduct(product.id)">
                <div class="flex flex-col items-center">
                    <div class="py-2">
                        <div class="py-2">
                            <label for="name">Invoice</label>
                        </div>
                        <input
                            type="text"
                            name="invoice"
                            id="invoice"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            v-model="formOrder.invoice"
                        />
                    </div>
                    <div class="">
                        <div class="py-2">
                            <label for="price">Status</label>
                        </div>
                        <input
                            type="text"
                            name="status"
                            id="status"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            v-model="formOrder.status"
                        />
                    </div>
                    <div class="">
                        <div class="py-2">
                            <label for="stock">Product</label>
                        </div>
                        <input
                            type="text"
                            id="product"
                            name="product"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            v-model="formOrder.product"
                        />
                    </div>
                    <div class="">
                        <div class="py-2">
                            <label for="stock">Qty</label>
                        </div>
                        <input
                            type="number"
                            id="qty"
                            name="qty"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            v-model="formOrder.qty"
                            />
                        </div>
                    <div class="">
                        <div class="py-2">
                            <label for="stock">User</label>
                        </div>
                        <input
                            type="text"
                            id="user"
                            name="user"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            v-model="formOrder.user"
                        />
                    </div>
                    <div class="">
                        <div class="py-2">
                            <label for="stock">Total</label>
                        </div>
                        <input
                        type="number"
                            id="total"
                            name="total"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            v-model="formOrder.total"
                        />
                    </div>
                    <div class="">
                        <div class="py-2">
                            <label for="stock">Amount</label>
                        </div>
                        <input
                            type="number"
                            name="amount"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            id=""
                            v-model="formOrder.amount"
                        />
                    </div>
                    <div class="flex items-center ml-auto gap-3 pt-5">
                        <Button type="submit" severity="success">Submit</Button>
                        <Button type="button" severity="danger"
                            ><Link :href="route('order.index')"
                                >Cancel</Link
                            ></Button
                        >
                    </div>
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import Button from "primevue/button";
import { reactive, computed, inject } from "vue";
import NoImage from '../../../../../public/assets/img/no-photo.png'

const Swal = inject("$swal");

const props = defineProps({
    products: Object,
    user: Object,
});

const form = reactive([
    {
        user_id: props.user.id,
        product_id: props.products.id || "",
        qty: 0,
        address: "",
        total_per_product: 0,
        amount: 0,
        total: 0,
    },
]);

const products = reactive(
    props.products.map((product) => ({
        ...product,
        qty: 0,
    }))
);

const cart = reactive([]);

const addToCart = (product) => {
    if (product.qty <= 0) {
        Swal.fire({
            toast: true,
            icon: "error",
            position: "top-end",
            title: "Please enter a valid Quantity!",
            showConfirmButton: false,
            timer: 2000,
        });
    }

    const existingProduct = cart.find((item) => item.product_id === product.id);

    if (existingProduct) {
        existingProduct.qty += product.qty;
        existingProduct.unit_price = product.price;
        existingProduct.total = existingProduct.qty * product.price;
        Swal.fire({
            toast: true,
            icon: "success",
            position: "top-end",
            title: "Product added to cart!",
            showConfirmButton: false,
            timer: 2000,
        });
    } else {
        cart.push({
            product_id: product.id,
            name: product.name,
            qty: product.qty,
            unit_price: product.price,
            total: product.qty * product.price,
        });
        Swal.fire({
            toast: true,
            icon: "success",
            position: "top-end",
            title: "Product added to cart!",
            showConfirmButton: false,
            timer: 2000,
        });
    }

    product.qty = 0;
};

const removeFromCart = (productId) => {
    const index = cart.findIndex((item) => item.product_id === productId);
    if (index !== -1) {
        cart.splice(index, 1); // Hapus produk dari cart
        Swal.fire({
            toast: true,
            icon: "success",
            position: "top-end",
            title: "Product removed from cart!",
            showConfirmButton: false,
            timer: 2000,
        });
    }
};

const cartTotal = computed(() =>
    cart.reduce((total, item) => total + item.total, 0)
);

const formatCurrency = (value) => {
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
    }).format(value);
};

const storeOrder = () => {
    if (cart.length <= 0) {
        Swal.fire({
            toast: true,
            icon: "error",
            position: "top-end",
            title: "Please add products to the cart!",
            showConfirmButton: false,
            timer: 2000,
        });
    }

    const cartData = cart.map((item) => {
        return {
            product_id: item.product_id,
            qty: item.qty,
            unit_price: item.unit_price,
        };
    });

    router.post(route("purchase.store"),
        {
            user_id: props.user.id,
            cart: cartData,
            address: form.address,
            amount: form.amount,
            total: cartTotal.value,
        },
        {
            onSuccess: () => {
                Swal.fire({
                    toast: true,
                    icon: "success",
                    position: "top-end",
                    title: "Order Created Successfully",
                    showConfirmButton: false,
                    timer: 2000,
                });
            },
            onError: () => {
                Swal.fire({
                    toast: true,
                    icon: "error",
                    position: "top-end",
                    title: "There was an error",
                    showConfirmButton: false,
                    timer: 2000,
                });
            },
        }
    );
};
</script>

<template>
    <Head title="Dashboard Shop" />

    <AdminLayout>
        <div class="flex justify-center pb-2 pt-5">
            <div class="px-2 w-full rounded-md shadow-md pb-10">
                <form @submit.prevent="storeOrder">
                    <div class="px-5 pb-2">
                        <div class="px-0 2xl:px-5 pb-2">
                            <div
                                v-for="product in products"
                                :key="product.id"
                                class="flex items-center gap-2 w-fit py-2"
                            >
                                <img
                                    :src="product.image ?
                                        `/storage/${product.product_images[0]?.image}`
                                            : NoImage
                                    "
                                    alt="Product Image"
                                    class="flex w-24 h-24"
                                />
                                <h2>{{ product.name }}</h2>
                                <p>
                                    Price: {{ formatCurrency(product.price) }}
                                </p>
                                <input
                                    class="w-[100px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 transition-all ease-in-out 3s"
                                    type="number"
                                    v-model="product.qty"
                                    min="0"
                                    placeholder="Quantity"
                                />
                                <div class="py-4">
                                    <span
                                        class="text-lg bg-blue-500 text-white px-2 py-1 rounded-full hover:bg-blue-600 cursor-pointer"
                                        @click="addToCart(product)"
                                    >
                                        +
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <h3 class="text-lg font-semibold">Cart Summary</h3>
                        <table
                            class="w-full border-collapse border border-slate-300"
                        >
                            <thead>
                                <tr class="bg-gray-100">
                                    <th
                                        class="border border-slate-300 py-2 px-4"
                                    >
                                        Item
                                    </th>
                                    <th
                                        class="border border-slate-300 py-2 px-4"
                                    >
                                        Qty
                                    </th>
                                    <th
                                        class="border border-slate-300 py-2 px-4"
                                    >
                                        Unit Price
                                    </th>
                                    <th
                                        class="border border-slate-300 py-2 px-4"
                                    >
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in cart" :key="item.id">
                                    <td
                                        class="border border-slate-300 py-2 px-4"
                                    >
                                        {{ item.name }}
                                    </td>
                                    <td
                                        class="border border-slate-300 py-2 px-4 text-center"
                                    >
                                        {{ item.qty }}
                                    </td>
                                    <td
                                        class="border border-slate-300 py-2 px-4 text-right"
                                    >
                                        {{
                                            formatCurrency(item.unit_price) || 0
                                        }}
                                    </td>
                                    <td
                                        class="border border-slate-300 py-2 px-4 text-center"
                                    >
                                        <button
                                            class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                            @click="
                                                removeFromCart(item.product_id)
                                            "
                                        >
                                            Remove
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="text-left mt-3">
                            <strong
                                >Total:
                                {{ formatCurrency(cartTotal) || 0 }}</strong
                            >
                        </div>
                    </div>
                    <div class="flex items-baseline gap-3 w-full">
                        <div class="flex gap-2 pb-2 2xl:px-5">
                            <div class="flex flex-col gap-2 w-[295px]">
                                <label for="price">Amount</label>
                                <input
                                    type="number"
                                    name="amount"
                                    id="amount"
                                    class="flex-auto w-full rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                                    v-model="form.amount"
                                    placeholder="Amount"
                                />
                            </div>
                        </div>
                        <div class="flex flex-col gap-2 pb-2 2xl:px-5 w-[600px]">
                            <label for="address">Address</label>
                            <textarea
                                name="address"
                                class="flex-auto w-full rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                                cols="30"
                                rows="10"
                                v-model="form.address"
                            >
                            </textarea>
                        </div>
                    </div>
                    <div class="text-end mt-5 mr-16">
                        <Button severity="success" type="submit">Order</Button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

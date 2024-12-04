<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { reactive, ref, watch, computed, inject } from "vue";
import Button from "primevue/button";
import Searchbar from "@/Components/Searchbar.vue";
import NoImage from '../../../../../public/assets/img/no-photo.png'

const Swal = inject("$swal");

const props = defineProps({
    products: Object,
    user: Object,
});

const form = reactive([
    {
        user_id: props.user.id,
        product_id: props.products.data.id || "",
        qty: 0,
        address: "",
        total_per_product: 0,
        amount: 0,
        total: 0,
    },
]);

const productsData = reactive(
    props.products.data.map((product) => ({
        ...product,
        qty: 0,
    }))
);
watch(
    () => props.products.data,
    (newData) => {
        productsData.splice(0, productsData.length, ...newData.map((product) => ({
            ...product,
            qty: 0,
        })))
    }
)

//Cart
const cart = reactive(
    JSON.parse(localStorage.getItem("cart")) || []
);
const saveCart = () => {
    localStorage.setItem("cart", JSON.stringify(cart));
};
const resetCart = () => {
    localStorage.removeItem("cart", JSON.stringify(cart));
}
watch(
    cart,
    () => {
        saveCart()
    },
    { deep:true }
)

// Search
const emit = defineEmits(["search"]);
const search = ref("");
const onSearch = () => {
    router.get(
        route("purchase.index"),
        { q: search.value },
        {
            preserveState: true,
            replace: true,
        }
    );
};
watch(search, (value) => {
    emit("search", value,);
});

// Pagination
const pageTo = (url) => {
    router.get(url, {
        preserveState: true,
        replace: true
    });
};
const productsPagination = reactive({
    links: props.products.links
})
watch(
    () => props.products.links,
    (newLinks) => {
        productsPagination.links = newLinks;
    }
)

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
            onFinish: () => {
                resetCart();
            }
        }
    );
};
</script>

<template>
    <Head title="Dashboard Shop" />

    <AdminLayout>
        <div class="flex justify-center">
            <div class="px-4 w-full rounded-md shadow-md bg-gray-300/70">
                <form @submit.prevent="storeOrder">
                    <div class="flex mt-4 items-baseline justify-evenly gap-3 w-full bg-white rounded-md">
                        <div class=" px-4 mt-4  w-[500px] 2xl:w-1/2">
                            <div class="px-0 2xl:px-5 pb-1">
                                <div class="pb-2">
                                    <Searchbar @submit.prevent="onSearch">
                                        <input
                                            v-model="search"
                                            type="text"
                                            name="productsSearch"
                                            id="products-search"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 transition-all ease-in 3s"
                                            placeholder="Search Products"
                                        />
                                    </Searchbar>
                                </div>
                                <div
                                    v-for="product in productsData"
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
                                            >{{ products.per_page }}</span
                                        >
                                        of
                                        <span
                                            class="font-semibold text-gray-900 dark:text-white"
                                            >{{ products.total }}</span
                                        >
                                        Entries
                                    </span>
                                    <ul class="flex items-center -space-x-px h-10 text-base">
                                        <li
                                            v-for="(item, index) in productsPagination.links"
                                            :key="index"
                                        >
                                            <a
                                                href="#"
                                                @click.prevent="pageTo(item.url)"
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
                        <div class="">
                            <h3 class="text-lg font-semibold pb-2">Cart Summary</h3>
                            <table
                                class="w-full border-collapse border border-primary-500"
                            >
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th
                                            class="text-center border border-primary-500 py-2 px-5"
                                        >
                                            No
                                        </th>
                                        <th
                                            class="text-center border border-primary-500 py-2 px-5"
                                        >
                                            Item
                                        </th>
                                        <th
                                            class="text-center border border-primary-500 py-2 px-5"
                                        >
                                            Qty
                                        </th>
                                        <th
                                            class="text-center border border-primary-500 py-2 px-5"
                                        >
                                            Unit Price
                                        </th>
                                        <th
                                            class="text-center border border-primary-500 py-2 px-5"
                                        >
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item, index in cart" :key="item.id">
                                        <td
                                            class="text-center border border-primary-500 py-2 px-5"
                                        >
                                            {{ index+1 }}
                                        </td>
                                        <td
                                            class="text-center border border-primary-500 py-2 px-5"
                                        >
                                            {{ item.name }}
                                        </td>
                                        <td
                                            class="text-center border border-primary-500 py-2 px-5"
                                        >
                                            {{ item.qty }}
                                        </td>
                                        <td
                                            class="text-center border border-primary-500 py-2 px-5"
                                        >
                                            {{
                                                formatCurrency(item.unit_price) || 0
                                            }}
                                        </td>
                                        <td
                                            class="text-center border border-slate-300 py-2 px-5 "
                                        >
                                            <button
                                                class="transition ease-in-out duration-300 hover:text-red-600 cursor-pointer"
                                                @click="
                                                    removeFromCart(item.product_id)
                                                "
                                            >
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-7">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>
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
                    </div>
                    <div class="flex items-baseline justify-start pl-10 gap-3 w-full pt-4 bg-white">
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
                    <div class="text-end mt-5 mb-2 mr-16">
                        <Button severity="success" type="submit">Order</Button>
                    </div>
                </form>
            </div>
        </div>
    </AdminLayout>
</template>

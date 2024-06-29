<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import Button from "primevue/button";
import { reactive, watch, inject } from "vue";

const Swal = inject('$swal')

const props = defineProps({
    products: Object,
    user: Object,
});

const form = reactive([
    {
        product: "",
        qty: 0,
        price: 0,
        amount: 0,
        total: 0,
    },
]);

const updatePrice = (index) => {
    const selectedProduct = props.products.find(
        (product) => product.id === form[index].product
    );
    if (selectedProduct) {
        form[index].price = selectedProduct.price;
    } else {
        form[index].price = 0;
    }
};
const updateTotal = (index) => {
    const selectedProduct = props.products.find(
        (product) => product.id === form[index].product
    );
    if (selectedProduct) {
        form[index].total = selectedProduct.price * form[index].qty;
    } else {
        form[index].total = 0;
    }
};

watch(
    () =>
        form.map((item) => ({
            product: item.product,
            qty: item.qty,
            total: item.total,
        })),
    (newValues, oldValues) => {
        newValues.forEach((newValue, index) => {
            if (
                newValue.product !== oldValues[index]?.product ||
                newValue.qty !== oldValues[index]?.qty ||
                newValue.total !== oldValues[index]?.total
            ) {
                updatePrice(index);
                updateTotal(index);
            }
        });
    },
    { deep: true }
);

const addRow = () => {
    form.push({
        product: "",
        qty: 0,
        price: 0,
        amount: 0,
    });
};

const removeRow = (index) => {
    if (form.length > 1) {
        form.splice(index);
    }
};

const storeOrder = () => {
    const inputs = form.map((item) => ({
        product_id: item.product,
        qty: item.qty,
        amount: item.amount,
    }));

    console.log(inputs);

    router.post(route("transaction.store"), {
        user_id: props.user.id,
        inputs: inputs,
    }, {
        onSuccess: () => {
            Swal.fire({
                toats: true,
                icon: "success",
                position: "top-end",
                title: "Order Created Successfully",
                showConfirmButton: false,
                timer: 2000
            })
        },
        onError: () => {
            Swal.fire({
                toats: true,
                icon: "error",
                position: "top-end",
                title: "There was an error",
                showConfirmButton: false,
                timer: 2000
            })
        }
    });
};
</script>

<template>
    <Head title="Dashboard Shop" />

    <AdminLayout>
        <div class="flex justify-center pb-2 pt-5">
            <div class="px-2 bg-white rounded-md shadow-md pb-10">
                <div class="flex-auto items-center mt-5 pb-5 px-5">
                    <Button severity="info" @click="addRow">
                        Add Product
                    </Button>
                </div>
                <form @submit.prevent="storeOrder">
                    <div
                        class="px-5 pb-2"
                        v-for="(item, index) in form"
                        :key="index"
                    >
                        <!-- <h2>item {{ index + 1 }}</h2>
                    {{ item }} -->
                        <div class="flex items-center gap-2 px-5 pb-2">
                            <div class="flex flex-col gap-2">
                                <label for="product">Product</label>
                                <select
                                    name="product"
                                    id="product"
                                    class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                                    v-model="item.product"
                                >
                                    <option value="" selected>Pilih Product</option>
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
                                <label for="qty">Quantity</label>
                                <input
                                    class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                                    type="number"
                                    name="qty"
                                    v-model="item.qty"
                                    id=""
                                />
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="price">Price per Piece</label>
                                <input
                                    class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                                    type="number"
                                    name="price"
                                    id="price"
                                    v-model="item.price"
                                    readonly
                                />
                            </div>
                            <div
                                class="rounded-full px-[7px] pt-1 bg-red-500 mt-[31px] hover:bg-red-700 hover:shadow-lg hover:shadow-slate-300 transition-all ease-in-out 5s"
                            >
                                <button class="" @click="removeRow(index)">
                                    <svg
                                        class="w-6 h-6 text-slate-200 dark:text-white"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M8.586 2.586A2 2 0 0 1 10 2h4a2 2 0 0 1 2 2v2h3a1 1 0 1 1 0 2v12a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V8a1 1 0 0 1 0-2h3V4a2 2 0 0 1 .586-1.414ZM10 6h4V4h-4v2Zm1 4a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Zm4 0a1 1 0 1 0-2 0v8a1 1 0 1 0 2 0v-8Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="flex gap-2 px-5 pb-2">
                            <div class="flex flex-col gap-2">
                                <label for="total">Total</label>
                                <input
                                    class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                                    type="number"
                                    name="total"
                                    id="total"
                                    v-model="item.total"
                                    readonly
                                />
                            </div>
                            <div class="flex flex-col gap-2">
                                <label for="price">Amount</label>
                                <input
                                    type="number"
                                    name="amount"
                                    id="amount"
                                    class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                                    v-model="item.amount"
                                    placeholder="Amount"
                                />
                            </div>
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

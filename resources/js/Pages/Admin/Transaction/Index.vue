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

// const updatePrice = (index) => {
//     const selectedProduct = props.products.find(
//         (product) => product.id === form[index].product
//     );
//     if (selectedProduct) {
//         form[index].price = selectedProduct.price;
//     } else {
//         form[index].price = 0;
//     }
// };
// const updateTotal = (index) => {
//     const selectedProduct = props.products.find(
//         (product) => product.id === form[index].product
//     );
//     if (selectedProduct) {
//         form[index].total = selectedProduct.price * form[index].qty;
//     } else {
//         form[index].total = 0;
//     }
// };

// watch(
//     () =>
//         form.map((item) => ({
//             product: item.product,
//             qty: item.qty,
//             total: item.total,
//         })),
//     (newValues, oldValues) => {
//         newValues.forEach((newValue, index) => {
//             if (
//                 newValue.product !== oldValues[index]?.product ||
//                 newValue.qty !== oldValues[index]?.qty ||
//                 newValue.total !== oldValues[index]?.total
//             ) {
//                 updatePrice(index);
//                 updateTotal(index);
//             }
//         });
//     },
//     { deep: true }
// );

const calculatedProductPrice = (price) => {
    price.total_per_product = product.price * product.qty
}

const formatCurrency = (value) => {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(value)
}

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
    const isValid = form.every(item => item.amount >= item.qty * item.price);
    if (!isValid) {
        Swal.fire({
            toast: true,
            icon: 'error',
            position: "top-end",
            title: 'Amount must be greater than or equal to total price!',
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }

    const inputs = form.map((item) => ({
        product_id: item.product,
        qty: item.qty,
        amount: item.amount,
    }));


    router.post(route("transaction.store"), {
        user_id: props.user.id,
        inputs: inputs,
    }, {
        onSuccess: () => {
            Swal.fire({
                toast: true,
                icon: "success",
                position: "top-end",
                title: "Order Created Successfully",
                showConfirmButton: false,
                timer: 2000
            })
        },
        onError: () => {
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
    // console.log(response.data);
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
                        <div class="px-0 2xl:px-5 pb-2">
                            <div v-for="product in products" :key="product.id" class="flex items-center gap-2 w-fit py-2">
                                <img :src="`/storage/${product.product_images[0].image}`" alt="Product Image" class="flex w-24 h-24" />
                                <h2>{{ product.name }}</h2>
                                <p>Price: {{ formatCurrency(product.price) }}</p>
                                <input
                                    type="number"
                                    v-model.number="product.quantity"
                                    min="0"
                                    @input="calculatedProductPrice(product)"
                                    placeholder="Quantity"
                                />
                                <p>Total: {{ formatCurrency(price.total_per_product) }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2 pb-2 2xl:px-5">
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

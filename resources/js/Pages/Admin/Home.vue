<script setup>
import AdminLayout from "../../Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
import { Bar } from "vue-chartjs";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale,
} from "chart.js";

const props = defineProps({
    categories: Array,
    orderTotal: Number,
    productTotal: Number,
    userTotal: Number,
});


ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
);

const randomColor = () => {
    let letters = "0123456789ABCDEF";
    let color = "#";
    for (let i = 0; i < 6; i++) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
};

// const chartOrderData = {
//     labels: ["Total Orders"],
//     datasets: props.categories.map((category) => ({
//         label: category.name,
//         data: props.orderByCategory
//             .filter((item) => item.category == category.name)
//             .map((item) => item.order_count),
//         backgroundColor: randomColor(),
//         borderColor: "rgba(1, 1, 1, 1)",
//     })),
// };

const chartOptions = {
    responsive: true,
    maintainAspectRatio: true,
};
</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout>
        <div class="my-2 mx-2">
            <div class="flex flex-wrap items-center justify-center gap-20 md:justify-between lg:justify-between xl:justify-between 2xl:justify-between lg:gap-2 md:gap-20 sm:gap-2 my-6">
                <div
                    class="bg-white rounded-lg border border-slate-800 px-10 py-8 w-[430px] md:w-[300px] lg:w-[300px] xl:w-[300px] 2xl:w-[430px]"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <h2
                                class="text-xl font-semibold text-slate-600 pb-2"
                            >
                                Total Orders
                            </h2>
                            <span class="text-3xl font-semibold">{{
                                orderTotal
                            }}</span>
                        </div>
                        <svg
                            class="w-10 h-10 text-primary-700 px-1 bg-slate-200 rounded-lg hover:bg-primary-active-color hover:text-white transition-all ease-in 3s dark:text-white"
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
                                d="M5 4h1.5L9 16m0 0h8m-8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm8 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm-8.5-3h9.25L19 7H7.312"
                            />
                        </svg>
                    </div>
                </div>
                <div
                    class="bg-white rounded-lg border border-slate-800 px-10 py-8 w-[430px] md:w-[300px] lg:w-[300px] xl:w-[300px] 2xl:w-[430px]"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <h2
                                class="text-xl font-semibold text-slate-600 pb-2"
                            >
                                Total Products
                            </h2>
                            <span class="text-3xl font-semibold">{{
                                productTotal
                            }}</span>
                        </div>
                        <svg
                            class="w-10 h-10 text-primary-700 px-1 bg-slate-200 rounded-lg hover:bg-primary-active-color hover:text-white transition-all ease-in 3s dark:text-white"
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
                                d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z"
                            />
                        </svg>
                    </div>
                </div>
                <div
                    class="bg-white rounded-lg border border-slate-800 px-10 py-8 w-[430px] md:w-[300px] lg:w-[300px] xl:w-[300px] 2xl:w-[430px]"
                >
                    <div class="flex items-center justify-between">
                        <div>
                            <h2
                                class="text-xl font-semibold text-slate-600 pb-2"
                            >
                                Total Users
                            </h2>
                            <span class="text-3xl font-semibold">{{
                                userTotal
                            }}</span>
                        </div>
                        <svg
                            class="w-10 h-10 text-primary-700 px-1 bg-slate-200 rounded-lg hover:bg-primary-active-color hover:text-white transition-all ease-in 3s dark:text-white"
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
                                stroke-width="2"
                                d="M4.5 17H4a1 1 0 0 1-1-1 3 3 0 0 1 3-3h1m0-3.05A2.5 2.5 0 1 1 9 5.5M19.5 17h.5a1 1 0 0 0 1-1 3 3 0 0 0-3-3h-1m0-3.05a2.5 2.5 0 1 0-2-4.45m.5 13.5h-7a1 1 0 0 1-1-1 3 3 0 0 1 3-3h3a3 3 0 0 1 3 3 1 1 0 0 1-1 1Zm-1-9.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0Z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="flex flex-wrap items-baseline justify-center 2xl:justify-between md:gap-2 lg:gap-2 xl:gap-2">
                <div class="my-4">
                    <div
                        class="bg-white rounded-lg border border-slate-800 shadow-md w-[380px] md:w-[500px] lg:w-[500px] xl:w-[500px] 2xl:w-[700px]"
                    >
                        <div class="px-5 pt-5 pb-2 font-bold">
                            <h2>Total Orders by Product Category</h2>
                        </div>
                        <Bar
                            class="px-5"
                            id="orderByCategory"
                            :options="chartOptions"
                        />
                    </div>
                </div>
                <div class="my-4">
                    <div
                        class="bg-white rounded-lg border border-slate-800 shadow-md w-[380px] md:w-[500px] lg:w-[500px] xl:w-[500px] 2xl:w-[700px]"
                    >
                        <div class="px-5 pt-5 pb-2 font-bold">
                            <h2>Best Selling Products</h2>
                        </div>
                        <div class="md:px-1 md:py-5">
                            <!-- <div
                                class="flex items-center justify-evenly pb-2"
                                v-for="(product, index) in bestSellingProducts"
                                :key="index"
                            >
                                <div class="font-bold">
                                    <p>{{ index + 1 }}.</p>
                                </div>
                                <div class="">
                                    <img
                                        class="block w-[100px]"
                                        :src="`/storage/${product.image}`"
                                        alt="product-image"
                                    />
                                </div>
                                <div class="">
                                    <h2 class="font-bold">
                                        {{ product.product }}
                                    </h2>
                                    <p>Rp. {{ product.price }}-</p>
                                </div>
                                <div class="">
                                    <h2 class="font-bold">Total Orders</h2>
                                    <p class="text-center">
                                        {{ product.order_count }}
                                    </p>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

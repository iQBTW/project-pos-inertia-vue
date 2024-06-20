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
    orderByCategory: Array,
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

const chartOrderData = {
    labels: ["Total Orders"],
    datasets: props.categories.map((category) => ({
        label: category.name,
        data: props.orderByCategory
            .filter((item) => item.category == category.name)
            .map((item) => item.order_count),
        backgroundColor: randomColor(),
        borderColor: "rgba(1, 1, 1, 1)",
    })),
};

const chartOptions = {
    responsive: true,
    maintainAspectRatio: true,
};
</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout>
        <div class="my-2 mx-2">
            <div class="grid grid-cols-3 gap-20 my-6">
                <div
                    class="bg-white rounded-lg border border-slate-800 px-10 py-8"
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
                                d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z"
                            />
                        </svg>
                    </div>
                </div>
                <div
                    class="bg-white rounded-lg border border-slate-800 px-10 py-8"
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
                                d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z"
                            />
                        </svg>
                    </div>
                </div>
                <div
                    class="bg-white rounded-lg border border-slate-800 px-10 py-8"
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
                                d="M9 10V6a3 3 0 0 1 3-3v0a3 3 0 0 1 3 3v4m3-2 .917 11.923A1 1 0 0 1 17.92 21H6.08a1 1 0 0 1-.997-1.077L6 8h12Z"
                            />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="my-4">
                <div class="bg-white rounded-lg border border-slate-800 shadow-md w-[600px]">
                    <div class="px-5 pt-5 pb-2 font-bold">
                        <h2>Total Orders by Product Category</h2>
                    </div>
                    <Bar
                        class="px-5"
                        id="orderByCategory"
                        :data="chartOrderData"
                        :options="chartOptions"
                    />
                </div>
            </div>
        </div>
    </AdminLayout>
</template>

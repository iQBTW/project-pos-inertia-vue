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
import { computed } from "vue";

const props = defineProps({
    orderByCategory: Array,
    categories: Array,
});

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
);

const chartOptions = {
    responsive: true,
};

const chartData = {
    labels: props.orderByCategory.map(item => item.category), // Mengambil nama kategori dari props.categories sebagai labels
    datasets: props.categories.map(category => ({
        label: category.name, // Menggunakan nama kategori sebagai label dataset
        data: props.orderByCategory
            .filter(item => item.category === category.name) // Filter data orderByCategory sesuai dengan kategori saat ini
            .map(item => item.order_count), // Ambil order_count dari data yang telah difilter
        backgroundColor: "rgba(255, 99, 132, 0.2)",
        borderColor: "rgba(255, 99, 132, 1)",
    })),
};

</script>

<template>
    <Head title="Dashboard" />

    <AdminLayout>
        <div class="pt-2 px-2 flex flex-auto">
            <div class="bg-white rounded-md shadow-md">
                <Bar
                    id="orderByCategory"
                    :data="chartData"
                    :options="chartOptions"
                />
            </div>
        </div>
    </AdminLayout>
</template>

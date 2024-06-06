<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, usePage } from "@inertiajs/vue3";
import {
    FwbA,
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
} from "flowbite-vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { ref } from "vue";

const { props } = usePage();

const users = ref(props.users)
</script>

<template>
    <Head title="Dashboard User"/>

    <AdminLayout>
        <Breadcrumb/>

        <div class="flex justify-center pt-2">
            <div class="w-full px-2">
                <fwb-table hoverable>
                    <fwb-table-head>
                        <fwb-table-head-cell>No</fwb-table-head-cell>
                        <fwb-table-head-cell>Name</fwb-table-head-cell>
                        <fwb-table-head-cell>Email</fwb-table-head-cell>
                        <fwb-table-head-cell>Address</fwb-table-head-cell>
                        <fwb-table-head-cell>
                            Edit
                        </fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row v-for="(user, index) in users" :key="user.id">
                            <fwb-table-cell>{{ index + 1 }}</fwb-table-cell>
                            <fwb-table-cell>{{ user.name }}</fwb-table-cell>
                            <fwb-table-cell>{{ user.email }}</fwb-table-cell>
                            <fwb-table-cell>{{ user.address }}</fwb-table-cell>
                            <fwb-table-cell>
                                <fwb-a href="#"> Edit </fwb-a>
                            </fwb-table-cell>
                        </fwb-table-row>
                    </fwb-table-body>
                </fwb-table>
            </div>
        </div>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head } from "@inertiajs/vue3";
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
</script>

<template>
    <Head title="Dashboard User"/>

    <AdminLayout>
        <Breadcrumb/>

        <div class="flex justify-center pt-2">
            <div class="w-full px-2">
                <fwb-table hoverable>
                    <fwb-table-head>
                        <fwb-table-head-cell>Product name</fwb-table-head-cell>
                        <fwb-table-head-cell>Color</fwb-table-head-cell>
                        <fwb-table-head-cell>Category</fwb-table-head-cell>
                        <fwb-table-head-cell>Price</fwb-table-head-cell>
                        <fwb-table-head-cell>
                            Edit
                        </fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row>
                            <fwb-table-cell>Apple MacBook Pro 17"</fwb-table-cell>
                            <fwb-table-cell>Sliver</fwb-table-cell>
                            <fwb-table-cell>Laptop</fwb-table-cell>
                            <fwb-table-cell>$2999</fwb-table-cell>
                            <fwb-table-cell>
                                <fwb-a href="#"> Edit </fwb-a>
                            </fwb-table-cell>
                        </fwb-table-row>
                        <fwb-table-row>
                            <fwb-table-cell>Microsoft Surface Pro</fwb-table-cell>
                            <fwb-table-cell>White</fwb-table-cell>
                            <fwb-table-cell>Laptop PC</fwb-table-cell>
                            <fwb-table-cell>$1999</fwb-table-cell>
                            <fwb-table-cell>
                                <fwb-a href="#"> Edit </fwb-a>
                            </fwb-table-cell>
                        </fwb-table-row>
                        <fwb-table-row>
                            <fwb-table-cell>Magic Mouse 2</fwb-table-cell>
                            <fwb-table-cell>Black</fwb-table-cell>
                            <fwb-table-cell>Accessories</fwb-table-cell>
                            <fwb-table-cell>$99</fwb-table-cell>
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

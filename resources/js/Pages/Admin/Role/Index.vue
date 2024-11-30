<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { Head, router, Link } from "@inertiajs/vue3";
import {
    FwbTable,
    FwbTableBody,
    FwbTableCell,
    FwbTableHead,
    FwbTableHeadCell,
    FwbTableRow,
} from "flowbite-vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Searchbar from "@/Components/Searchbar.vue";
import InputText from "primevue/inputtext";
import Dialog from "primevue/dialog";
import Button from "primevue/button";
import { ref, watch, reactive, inject } from "vue";

const Swal = inject('$swal')

const props = defineProps({
    roles: Object,
});


const formRole = reactive({
    id: null,
    name: null,
});

const isEdit = ref(false);
const isDelete = ref(false);
const showModal = ref(false);

// Searchbar
const emit = defineEmits(["search"]);
const search = ref("");
const onSearch = () => {
    router.get(
        route("role.index"),
        { q: search.value },
        {
            preserveState: true,
            replace: true,
        }
    );
};
watch(search, (value) => {
    emit("search", value);
});

//Create Modal
const openCreateModal = () => {
    isEdit.value = false;
    isDelete.value = false;
    showModal.value = true;

    formRole.name = null;
}

//Edit Modal
const openEditModal = (role, index) => {
    isEdit.value = true;
    isDelete.value = false;
    showModal.value = true;

    formRole.name = role.name;
    formRole.id = role.id;
};

//Delete Modal
const openDeleteModal = (role, id) => {
    isEdit.value = false;
    isDelete.value = true;
    showModal.value = true;

    formRole.id  = role.id
    formRole.name = role.name
}
const confirmDelete = () => {
    deleteRole(formRole.id);
    showModal.value = false;
}

//Create
const storeRole = () => {
    try {
        router.post(route("role.store"), formRole, {
            onSuccess: () => {
                Swal.fire({
                    toast: true,
                    icon: "success",
                    position: "top-end",
                    title: "Role created successfully",
                    showConfirmButton: false,
                    timer: 2000
                })
                showModal.value = false;
                formRole.name = null;
            },
            onError: (errors) => {
                console.log(errors);
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
    } catch (e) {
        console.log(e);
    }
}

//Edit
const updateRole = () => {
    try {
        router.put(`/dashboard/role/${formRole.id}`, formRole, {
            onSuccess: () => {
                Swal.fire({
                    toast: true,
                    icon: "success",
                    position: "top-end",
                    title: "Role updated successfully",
                    showConfirmButton: false,
                    timer: 2000
                })
                showModal.value = false;
                formRole.name = null;
            },
            onError: (errors) => {
                console.log(errors);
                Swal.fire({
                    toast: true,
                    icon: "error",
                    position: "top-end",
                    title: "There was an error",
                    showConfirmButton: false,
                    timer: 2000
                })
                showModal.value = false;
                formRole.name = null;
            }
        })
    } catch (e){
        console.log(e);
    }
}

//Delete
const deleteRole = (id) => {
    router.delete('/dashboard/role/' + id, {
        onSuccess: () => {
            Swal.fire({
                toast: true,
                icon: "success",
                position: "top-end",
                title: "Role has been deleted successfully",
                showConfirmButton: false,
                timer: 2000
            })
        },
        onError: (errors) => {
            console.log(errors);
            Swal.fire({
                toast: true,
                icon: "error",
                position: "top-end",
                title: "There was an error",
                showConfirmButton: false,
                timer: 2000
            })
        }
    })
}

// Pagination
const pageTo = (url) => {
    router.get(url);
};
</script>

<template>
    <Head title="Dashboard Role" />

    <AdminLayout>
        <!-- Header Section -->
        <Breadcrumb title="All Roles">
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
                            :href="route('role.index')"
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white"
                            >Roles</Link
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
                            >List</span
                        >
                    </div>
                </li>
            </template>
            <template #search>
                <div class="sm:flex">
                    <Searchbar @submit.prevent="onSearch">
                        <input
                            v-model="search"
                            type="text"
                            name="rolesSearch"
                            id="roles-search"
                            class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500 transition-all ease-in 3s"
                            placeholder="Search roles"
                        />
                    </Searchbar>
                    <div
                        class="flex items-center ml-auto space-x-2 sm:space-x-3"
                    >
                        <Button
                            label="show"
                            @click="openCreateModal"
                            severity="success"
                            class="inline-flex items-center justify-center w-1/2 px-3 py-2 text-sm font-medium text-center text-black rounded-lg hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 sm:w-auto dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 transition-all ease-in 3s"
                        >
                            <svg
                                class="w-5 h-5 mr-2 -ml-1"
                                fill="currentColor"
                                viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg"
                            >
                                <path
                                    fill-rule="evenodd"
                                    d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                    clip-rule="evenodd"
                                ></path>
                            </svg>
                            Add Role
                        </Button>
                    </div>
                </div>
            </template>
        </Breadcrumb>

        <div class="pt-2 pb-2">
            <div class="w-full px-2 bg-gray-300/50 min-h-screen pt-2">
                <fwb-table hoverable>
                    <fwb-table-head>
                        <fwb-table-head-cell>No</fwb-table-head-cell>
                        <fwb-table-head-cell>Name</fwb-table-head-cell>
                    </fwb-table-head>
                    <fwb-table-body>
                        <fwb-table-row
                            v-for="role, index in roles.data"
                            :key="index"
                        >
                            <fwb-table-cell>{{ index + 1 }}</fwb-table-cell>
                            <fwb-table-cell>{{ role.name }}</fwb-table-cell>
                            <fwb-table-cell class="flex gap-2">
                                <Button
                                    class="transition-all ease-in 3s border border-yellow-300 hover:text-white hover:bg-yellow-300"
                                    @click="openEditModal(role, index)"
                                >
                                    Edit
                                </Button>
                                <Button
                                    severity="danger"
                                    class="transition-all ease-in 3s border hover:text-white hover:bg-red-800"
                                    @click.prevent = "openDeleteModal(role, role.id)"
                                >
                                    Delete
                                </Button>
                            </fwb-table-cell>
                        </fwb-table-row>
                    </fwb-table-body>
                </fwb-table>
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
                            >{{ roles.per_page }}</span
                        >
                        of
                        <span
                            class="font-semibold text-gray-900 dark:text-white"
                            >{{ roles.total }}</span
                        >
                        Entries
                    </span>
                    <ul class="flex items-center -space-x-px h-10 text-base">
                        <li v-for="(item, index) in roles.links" :key="index">
                            <a
                                href="#"
                                @click="pageTo(item.url)"
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

        <Dialog
            class="bg-white"
            v-model:visible="showModal"
            modal
            :header="isEdit ? 'Edit Role' : isDelete ? 'Delete Role' : 'Create Role'"
            :style="{ width: '25rem' }"
        >
            <form @submit.prevent="isEdit ? updateRole() : isDelete ? confirmDelete() : storeRole()">
                <span
                    class="text-surface-600 dark:text-surface-0/70 block mb-5"
                    >{{ isEdit ? 'Edit an existing Role' : isDelete ? 'Delete an existing Role' : 'Create a new Role' }}</span
                >

                <div v-if="!isDelete" class="flex items-center gap-3 mb-3">
                    <div class="">
                        <label
                            for="name"
                            class="font-semibold w-[6rem]"
                            >Role Name</label
                        >
                    </div>
                    <InputText
                        id="name"
                        v-model="formRole.name"
                        class="flex-auto border-0 ring-1 ring-bg-primary-500 focus:ring-1 focus:ring-primary-500"
                        autocomplete="off"
                    />
                </div>

                <div v-if="isDelete" class="pb-2">
                    <p>Are you sure you want to delete <b>{{ formRole.name }}</b> Role?</p>
                </div>

                <div class="flex justify-end gap-2">
                    <Button
                        type="button"
                        label="Cancel"
                        severity="danger"
                        class="hover:bg-red-700 transition-all ease-in 3s"
                        @click="showModal = false"
                    ></Button>
                    <Button
                        type="submit"
                        :class="isEdit ? 'hover:bg-green-700 transition-all ease-in 3s' : isDelete ? 'hover:bg-red-700 transition-all ease-in 3s' : 'hover:bg-green-700 transition-all ease-in 3s'"
                        :severity="isEdit ? 'success' : isDelete ? 'warning' : 'success'"
                        :label="isEdit ? 'Submit' : isDelete ? 'Delete' : 'Submit'"
                    ></Button>
                </div>
            </form>
        </Dialog>
    </AdminLayout>
</template>

<script setup>
import AdminLayout from "@/Layouts/AdminLayout.vue";
import { inject, reactive } from "vue";
import { Head, router, Link } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import Button from "primevue/button";

const Swal = inject('$swal')

const props = defineProps({
    roles: Object,
});

const formUser = reactive({
    name: null,
    email: null,
    password: null,
    address: null,
    role: null
});

const storeUser = () => {
    router.post(route("user.store"), formUser, {
        onError: () => {
            Swal.fire({
                toats: true,
                icon: "error",
                position: "top-end",
                title: "There was an error",
                showConfirmButton: false,
                timer: 2000
            })
        },
        onSuccess: () => {
            Swal.fire({
                toats: true,
                icon: "success",
                position: "top-end",
                title: "User Created Successfully",
                showConfirmButton: false,
                timer: 2000
            })
        }
    });
}
</script>

<template>
    <Head title="Dashboard User" />

    <AdminLayout>
        <!-- Header Section -->
        <Breadcrumb title="Create New User">
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
                            :href="route('user.index')"
                            class="ml-1 text-gray-700 hover:text-primary-600 md:ml-2 dark:text-gray-300 dark:hover:text-white"
                            >Users</Link
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
                            >New User</span
                        >
                    </div>
                </li>
            </template>
        </Breadcrumb>

        <!-- Content Section -->
        <div class="p-4 bg-white w-fit rounded-lg shadow-md mt-5 mb-5 mx-auto">
            <form @submit.prevent="storeUser">
                <div class="flex gap-5 justify-center items-center">
                    <div class="py-2">
                        <div class="py-2">
                            <label for="name">Name</label>
                        </div>
                        <input
                            type="text"
                            name="name"
                            id="name"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            v-model="formUser.name"
                        />
                    </div>
                    <div class="">
                        <div class="py-2">
                            <label for="stock">Email</label>
                        </div>
                        <input
                            type="email"
                            name="email"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            id=""
                            v-model="formUser.email"
                        />
                    </div>
                </div>
                <div class="flex gap-5 justify-center items-baseline">
                    <div class="">
                        <div class="py-2">
                            <label for="price">Password</label>
                        </div>
                        <input
                            type="password"
                            name="password"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            id=""
                            v-model="formUser.password"
                        />
                    </div>
                    <div class="">
                        <div class="py-2">
                            <label for="category">Role</label>
                        </div>
                        <select
                            name="category_id"
                            class="flex-auto w-[295px] rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s"
                            id=""
                            v-model="formUser.role"
                        >
                            <option
                                v-for="role in roles"
                                :key="role.id"
                                :value="role.name"
                            >
                                {{ role.name }}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="">
                    <div class="py-2 w-full">
                        <label for="price">Address</label>
                    </div>
                    <textarea name="address" class="flex-auto w-full rounded-md border-0 ring-1 ring-slate-700 focus:border-0 focus:ring-primary-500 focus:transition-all ease-in-out 3s" cols="30" rows="10" v-model="formUser.address">
                    </textarea>
                </div>

                <div class="flex justify-end items-center ml-auto gap-3 pt-5">
                    <Button type="submit" severity="success">Submit</Button>
                    <Button type="button" severity="danger"
                        ><Link :href="route('user.index')"
                            >Cancel</Link
                        ></Button
                    >
                </div>
            </form>
        </div>
    </AdminLayout>
</template>

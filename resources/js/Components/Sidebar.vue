<script setup>
import { FwbSidebar, FwbSidebarItem } from "flowbite-vue";
import { Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import DropdownMenu from "@/Components/DropdownMenu.vue";
import NotificationDropdown from "@/Components/NotificationDropdown.vue";

const showSidebar = ref(true);
</script>
<template>
    <nav
        class="fixed z-30 w-full bg-white border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700"
    >
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-center">
                    <button
                        @click="showSidebar = !showSidebar"
                        id="toggleSidebarMobile"
                        aria-expanded="true"
                        aria-controls="sidebar"
                        class="p-2 text-gray-600 rounded cursor-pointer lg:hidden hover:text-gray-900 hover:bg-gray-100 focus:bg-gray-100 dark:focus:bg-gray-700 focus:ring-2 focus:ring-gray-100 dark:focus:ring-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    >
                        <svg
                            id="toggleSidebarMobileHamburger"
                            class="w-6 h-6"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                        <svg
                            id="toggleSidebarMobileClose"
                            class="hidden w-6 h-6"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </button>
                    <a
                        href="https://flowbite-admin-dashboard.vercel.app/"
                        class="flex ml-2 md:mr-24"
                    >
                        <!-- <img
                            src="https://flowbite-admin-dashboard.vercel.app/images/logo.svg"
                            class="h-8 mr-3"
                            alt="FlowBite Logo"
                        /> -->
                        <span
                            class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white"
                            >Dashboard | Tokofy</span
                        >
                    </a>
                    <form
                        action="#"
                        method="GET"
                        class="hidden lg:block lg:pl-3.5"
                    >
                        <label for="topbar-search" class="sr-only"
                            >Search</label
                        >
                        <div class="relative mt-1 lg:w-96">
                            <div
                                class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                            >
                                <svg
                                    class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                    fill="currentColor"
                                    viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                >
                                    <path
                                        fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd"
                                    ></path>
                                </svg>
                            </div>
                            <input
                                type="text"
                                name="email"
                                id="topbar-search"
                                class="bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Search"
                            />
                        </div>
                    </form>
                </div>
                <div class="flex items-center">
                    <button
                        id="toggleSidebarMobileSearch"
                        type="button"
                        class="p-2 text-gray-500 rounded-lg lg:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                    >
                        <span class="sr-only">Search</span>

                        <svg
                            class="w-6 h-6"
                            fill="currentColor"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                clip-rule="evenodd"
                            ></path>
                        </svg>
                    </button>

                    <NotificationDropdown />
                    <!-- Dropdown menu -->
                    <DropdownMenu />
                </div>
            </div>
        </div>
    </nav>

    <div class="flex pt-16 overflow-hidden bg-orange-500 dark:bg-gray-900">
        <aside
            class="fixed top-0 left-0 z-20 flex-col flex-shrink-0 w-64 h-full pt-16 font-normal duration-75 transition-width"
            :class="{
                flex: showSidebar,
                'lg:flex': showSidebar,
                'lg:flex': !showSidebar,
                hidden: !showSidebar,
                'sm:hidden': !showSidebar,
                'md:hidden': !showSidebar,
            }"
        >
            <div
                class="relative flex flex-col flex-1 min-h-0 pt-0 bg-white border-r border-gray-200 dark:bg-gray-800 dark:border-gray-700"
            >
                <div class="flex flex-col flex-1 pb-4">
                    <fwb-sidebar class="shadow-lg">
                        <Link :href="route('dashboard')">
                            <fwb-sidebar-item
                                class="hover:bg-slate-200 transition-all ease-in 3s mt-2"
                            >
                                <template #icon>
                                    <svg
                                        class="w-6 h-6 text-gray-500 transition-all duration-75 ease-in dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 22 21"
                                    >
                                        <path
                                            d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"
                                        />
                                        <path
                                            d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"
                                        />
                                    </svg>
                                </template>
                                <template #default> Dashboard </template>
                            </fwb-sidebar-item>
                        </Link>
                        <Link :href="route('product.index')">
                            <fwb-sidebar-item
                                class="hover:bg-slate-200 transition-all ease-in 3s mt-2"
                            >
                                <template #icon>
                                    <svg
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition-all ease-in duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white active:text-gray-900 dark:active:text-white"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 18 20"
                                    >
                                        <path
                                            d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z"
                                        />
                                    </svg>
                                </template>
                                <template #default>Product</template>
                            </fwb-sidebar-item>
                        </Link>
                        <Link :href="route('order.index')">
                            <fwb-sidebar-item
                                class="hover:bg-slate-200 transition-all ease-in 3s mt-2"
                            >
                                <template #icon>
                                    <svg
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition-all ease-in duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white active:text-gray-900 dark:active:text-white"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M8 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1h2a2 2 0 0 1 2 2v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h2Zm6 1h-4v2H9a1 1 0 0 0 0 2h6a1 1 0 1 0 0-2h-1V4Zm-6 8a1 1 0 0 1 1-1h6a1 1 0 1 1 0 2H9a1 1 0 0 1-1-1Zm1 3a1 1 0 1 0 0 2h6a1 1 0 1 0 0-2H9Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </template>
                                <template #default>Order</template>
                            </fwb-sidebar-item>
                        </Link>
                        <Link :href="route('category.index')">
                            <fwb-sidebar-item
                                class="hover:bg-slate-200 transition-all ease-in 3s mt-2"
                            >
                                <template #icon>
                                    <svg
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition-all ease-in duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white active:text-gray-900 dark:active:text-white"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M20 10H4v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8ZM9 13v-1h6v1a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1Z"
                                            clip-rule="evenodd"
                                        />
                                        <path
                                            d="M2 6a2 2 0 0 1 2-2h16a2 2 0 1 1 0 4H4a2 2 0 0 1-2-2Z"
                                        />
                                    </svg>
                                </template>
                                <template #default>Category</template>
                            </fwb-sidebar-item>
                        </Link>
                        <Link :href="route('user.index')">
                            <fwb-sidebar-item
                                class="hover:bg-slate-200 transition-all ease-in 3s mt-2"
                            >
                                <template #icon>
                                    <svg
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition-all ease-in duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="currentColor"
                                        viewBox="0 0 20 18"
                                    >
                                        <path
                                            d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z"
                                        />
                                    </svg>
                                </template>
                                <template #default>User</template>
                            </fwb-sidebar-item>
                        </Link>
                        <hr />
                    </fwb-sidebar>
                </div>
            </div>
        </aside>
    </div>
</template>

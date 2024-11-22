<script setup>
import { FwbSidebar, FwbSidebarItem } from "flowbite-vue";
import { usePermission } from "@/Composables/permission";
import { Link, usePage } from "@inertiajs/vue3";
import { ref } from "vue";
import DropdownMenu from "@/Components/DropdownMenu.vue";
import NotificationDropdown from "@/Components/NotificationDropdown.vue";

const { hasRole } = usePermission();

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
                    <!-- <template v-if="hasRole('admin')"> -->
                    <fwb-sidebar class="shadow-lg">
                        <Link :href="route('dashboard')">
                            <fwb-sidebar-item
                                class="hover:bg-primary-highlight transition-all ease-in 3s mt-2"
                                :class="{
                                    '!bg-primary-active-color !text-white':
                                        route().current('dashboard'),
                                }"
                            >
                                <template #icon>
                                    <svg
                                        class="w-6 h-6 text-gray-500 transition-all duration-75 ease-in dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                        :class="{
                                            '!text-white':
                                                route().current('dashboard'),
                                        }"
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
                                class="hover:bg-primary-highlight transition-all ease-in 3s mt-2"
                                :class="{
                                    '!bg-primary-active-color !text-white':
                                        route().current('product.index') ||
                                        route().current('product.create') ||
                                        route().current('product.edit'),
                                }"
                            >
                                <template #icon>
                                    <svg
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition-all ease-in duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white active:text-gray-900 dark:active:text-white"
                                        :class="{
                                            '!text-white':
                                                route().current(
                                                    'product.index'
                                                ) ||
                                                route().current(
                                                    'product.create'
                                                ) ||
                                                route().current('product.edit'),
                                        }"
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
                        <Link :href="route('category.index')">
                            <fwb-sidebar-item
                                class="hover:bg-primary-highlight transition-all ease-in 3s mt-2"
                                :class="{
                                    '!bg-primary-active-color !text-white':
                                        route().current('category.index'),
                                }"
                            >
                                <template #icon>
                                    <svg
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition-all ease-in duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white active:text-gray-900 dark:active:text-white"
                                        :class="{
                                            '!text-white':
                                                route().current(
                                                    'category.index'
                                                ),
                                        }"
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
                        <Link :href="route('product_category.index')">
                            <fwb-sidebar-item
                                class="hover:bg-primary-highlight transition-all ease-in 3s mt-2"
                                :class="{
                                    '!bg-primary-active-color !text-white':
                                        route().current('product_category.index'),
                                }"
                            >
                                <template #icon>
                                    <svg
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition-all ease-in duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white active:text-gray-900 dark:active:text-white"
                                        :class="{
                                            '!text-white':
                                                route().current(
                                                    'product_category.index'
                                                ),
                                        }"
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
                                <template #default>Product Category</template>
                            </fwb-sidebar-item>
                        </Link>
                        <Link :href="route('order.index')">
                            <fwb-sidebar-item
                                class="hover:bg-primary-highlight transition-all ease-in 3s mt-2"
                                :class="{
                                    '!bg-primary-active-color !text-white':
                                        route().current('order.index'),
                                }"
                            >
                                <template #icon>
                                    <svg
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition-all ease-in duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white active:text-gray-900 dark:active:text-white"
                                        :class="{
                                            '!text-white':
                                                route().current('order.index'),
                                        }"
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

                        <Link :href="route('user.index')">
                            <fwb-sidebar-item
                                class="hover:bg-primary-highlight transition-all ease-in 3s mt-2"
                                :class="{
                                    '!bg-primary-active-color !text-white':
                                        route().current('user.index') || route().current('user.create'),
                                }"
                            >
                                <template #icon>
                                    <svg
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition-all ease-in duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                        :class="{
                                            '!text-white':
                                                route().current('user.index') || route().current('user.create'),
                                        }"
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
                        <Link :href="route('role.index')">
                            <fwb-sidebar-item
                                class="hover:bg-primary-highlight transition-all ease-in 3s mt-2"
                                :class="{
                                    '!bg-primary-active-color !text-white':
                                        route().current('role.index'),
                                }"
                            >
                                <template #icon>
                                    <svg
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition-all ease-in duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                        :class="{
                                            '!text-white':
                                                route().current('role.index'),
                                        }"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M10 2a3 3 0 0 0-3 3v1H5a3 3 0 0 0-3 3v2.382l1.447.723.005.003.027.013.12.056c.108.05.272.123.486.212.429.177 1.056.416 1.834.655C7.481 13.524 9.63 14 12 14c2.372 0 4.52-.475 6.08-.956.78-.24 1.406-.478 1.835-.655a14.028 14.028 0 0 0 .606-.268l.027-.013.005-.002L22 11.381V9a3 3 0 0 0-3-3h-2V5a3 3 0 0 0-3-3h-4Zm5 4V5a1 1 0 0 0-1-1h-4a1 1 0 0 0-1 1v1h6Zm6.447 7.894.553-.276V19a3 3 0 0 1-3 3H5a3 3 0 0 1-3-3v-5.382l.553.276.002.002.004.002.013.006.041.02.151.07c.13.06.318.144.557.242.478.198 1.163.46 2.01.72C7.019 15.476 9.37 16 12 16c2.628 0 4.98-.525 6.67-1.044a22.95 22.95 0 0 0 2.01-.72 15.994 15.994 0 0 0 .707-.312l.041-.02.013-.006.004-.002.001-.001-.431-.866.432.865ZM12 10a1 1 0 1 0 0 2h.01a1 1 0 1 0 0-2H12Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </template>
                                <template #default>Role</template>
                            </fwb-sidebar-item>
                        </Link>
                        <Link :href="route('permission.index')">
                            <fwb-sidebar-item
                                class="hover:bg-primary-highlight transition-all ease-in 3s mt-2"
                                :class="{
                                    '!bg-primary-active-color !text-white':
                                        route().current('permission.index'),
                                }"
                            >
                                <template #icon>
                                    <svg
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition-all ease-in duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                        :class="{
                                            '!text-white':
                                                route().current(
                                                    'permission.index'
                                                ),
                                        }"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M14 4.182A4.136 4.136 0 0 1 16.9 3c1.087 0 2.13.425 2.899 1.182A4.01 4.01 0 0 1 21 7.037c0 1.068-.43 2.092-1.194 2.849L18.5 11.214l-5.8-5.71 1.287-1.31.012-.012Zm-2.717 2.763L6.186 12.13l2.175 2.141 5.063-5.218-2.141-2.108Zm-6.25 6.886-1.98 5.849a.992.992 0 0 0 .245 1.026 1.03 1.03 0 0 0 1.043.242L10.282 19l-5.25-5.168Zm6.954 4.01 5.096-5.186-2.218-2.183-5.063 5.218 2.185 2.15Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </template>
                                <template #default>Permission</template>
                            </fwb-sidebar-item>
                        </Link>
                        <hr />
                        <Link :href="route('transaction.index')">
                            <fwb-sidebar-item
                                class="hover:bg-primary-highlight transition-all ease-in 3s mt-2"
                                :class="{
                                    '!bg-primary-active-color !text-white':
                                        route().current('transaction.index'),
                                }"
                            >
                                <template #icon>
                                    <svg
                                        class="flex-shrink-0 w-6 h-6 text-gray-500 transition-all ease-in duration-75 dark:text-gray-400 group-hover:text-gray-900 dark:group-hover:text-white"
                                        :class="{
                                            '!text-white':
                                                route().current(
                                                    'transaction.index'
                                                ),
                                        }"
                                        aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg"
                                        width="24"
                                        height="24"
                                        fill="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M4 4a1 1 0 0 1 1-1h1.5a1 1 0 0 1 .979.796L7.939 6H19a1 1 0 0 1 .979 1.204l-1.25 6a1 1 0 0 1-.979.796H9.605l.208 1H17a3 3 0 1 1-2.83 2h-2.34a3 3 0 1 1-4.009-1.76L5.686 5H5a1 1 0 0 1-1-1Z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </template>
                                <template #default>Purchase Product</template>
                            </fwb-sidebar-item>
                        </Link>
                    </fwb-sidebar>
                    <!-- </template> -->
                    <!-- <template v-if="hasRole('user')"> -->
                    <!-- <fwb-sidebar class="shadow-lg"></fwb-sidebar> -->
                    <!-- </template> -->
                </div>
            </div>
        </aside>
    </div>
</template>

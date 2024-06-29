<script setup>
import { Link, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
const page = usePage();

const user = computed(() => page.props.auth.user);
</script>

<template>
    <div class="flex items-center ml-3">
        <button
            type="button"
            class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
            id="user-menu-button-2"
            aria-expanded="false"
            data-dropdown-toggle="dropdown-profile"
        >
            <span class="sr-only">Open user menu</span>
            <img
                class="w-8 h-8 rounded-full"
                src="https://flowbite.com/docs/images/people/profile-picture-5.jpg"
                alt="user photo"
            />
        </button>
        <div
            class="z-50 my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600 hidden position: absolute; inset: 0px auto auto 0px; margin: 0px; transform: translate(1843px, 61px)"
            id="dropdown-profile"
            data-popper-placement="bottom"
        >
            <div class="px-4 py-3" role="none">
                <p class="text-sm text-gray-900 dark:text-white" role="none">
                    {{ user.name }}
                </p>
                <p
                    class="text-sm font-medium text-gray-900 truncate dark:text-gray-300"
                    role="none"
                >
                    {{ user.email }}
                </p>
            </div>
            <ul class="py-1" role="none">
                <li>
                    <Link
                        :href="route('profile.edit')"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                        role="menuitem"
                        >Profile</Link
                    >
                </li>
                <li>
                    <Link
                        :href="route('logout')"
                        method="post"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                        role="menuitem"
                        >Sign out</Link
                    >
                </li>
            </ul>
        </div>
    </div>
</template>

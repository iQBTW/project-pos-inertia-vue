<script setup>
const props = defineProps({
    placeholder: String,
    name: String,
    action: String,
    method: String,
});
</script>

<template>
    <div
        class="items-center hidden mb-3 sm:flex sm:divide-x sm:divide-gray-100 sm:mb-0 dark:divide-gray-700"
    >
        <form class="lg:pr-3" :action="props.action" :method="props.method">
            <label class="sr-only">Search</label>
            <div class="relative mt-1 lg:w-64 xl:w-96">
                <slot/>
            </div>
        </form>
    </div>
</template>

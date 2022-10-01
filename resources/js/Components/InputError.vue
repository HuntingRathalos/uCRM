<script setup>
import { usePage } from "@inertiajs/inertia-vue3";
import { computed } from "@vue/reactivity";

// defineProps(["message"]);
const message = computed(() => usePage().props.value.errors);
const hasErrors = computed(() => Object.keys(message.value).length > 0);
</script>

<template>
    <div v-show="hasErrors">
        <div class="font-medium text-red-600">問題が発生しました。</div>
        <ul class="mt-3 list-disc list-inside text-sm text-red-600">
            <li v-for="(error, key) in message" :key="key">{{ error }}</li>
        </ul>
        <!-- <p class="text-sm text-red-600">
            {{ message }}
        </p> -->
    </div>
</template>

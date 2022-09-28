<script setup>
import { Link } from "@inertiajs/inertia-vue3";
</script>
<template>
    testです。
    <a href="/">aaa</a>
    <Link href="/">link</Link><br />
    <Link :href="route('inertia.index')">名前付きルート</Link>
</template>

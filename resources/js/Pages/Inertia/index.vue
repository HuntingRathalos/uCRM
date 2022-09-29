<script setup></script>
<template>
    <div v-if="$page.props.flash.message" class="bg-red-300">
        {{ $page.props.flash.message }}
    </div>
    <p>aaa</p>
</template>

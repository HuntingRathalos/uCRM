<script setup>
import GuestLayoutVue from "@/Layouts/GuestLayout.vue";
import InputLabelVue from "@/Components/InputLabel.vue";
import TextInputVue from "@/Components/TextInput.vue";
</script>
<template>
    <GuestLayoutVue>
        <InputLabelVue value="件名">タイトル</InputLabelVue>
        <TextInputVue modelValue="初期値初期値"></TextInputVue>
    </GuestLayoutVue>
</template>

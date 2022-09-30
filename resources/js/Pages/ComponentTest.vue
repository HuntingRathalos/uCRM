<script setup>
import GuestLayoutVue from "@/Layouts/GuestLayout.vue";
import InputLabelVue from "@/Components/InputLabel.vue";
import TextInputVue from "@/Components/TextInput.vue";

const emitTest = (e) => console.log(e);
</script>
<template>
    <GuestLayoutVue>
        <InputLabelVue value="件名">タイトル</InputLabelVue>
        <TextInputVue
            @update:modelValue="emitTest"
            modelValue="初期値初期"
        ></TextInputVue>
    </GuestLayoutVue>
</template>

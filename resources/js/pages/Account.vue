<template>
    <Layout>
        <div class="flex flex-column justify-center items-center">
            <v-avatar color="grey-darken-1" size="120"></v-avatar>

            <div class="text-h4 mt-5">{{ user.name }}</div>
            <div class="text-h6 mt-5">{{ user.email }}</div>
            <div class="text-body">
                Utworzono: {{ new Date(user.created_at).toDateString() }}
            </div>
            <div class="text-body">
                Wypożyczone książki:
                {{ books.length }} / 6
            </div>
        </div>
    </Layout>
</template>

<script setup>
import { computed } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import Layout from "../layout/Base.vue";

const user = computed(() => usePage().props.value.auth.user);
const books = computed(() => usePage().props.value.auth.books);
</script>

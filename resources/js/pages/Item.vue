<template>
    <Layout>
        <v-row>
            <v-col cols="2">
                <v-img height="250" :src="book.image"></v-img>
            </v-col>
            <v-col cols="10">
                <div class="text-h4">{{ book.title }}</div>
                <div class="text-button">{{ book.author }}</div>
                <div class="text-button">Kod: {{ book.id }}</div>
                <div class="text-body">
                    wydane przez: {{ book.publisher }} rok:
                    {{ new Date(book.release).getFullYear() }}
                </div>
                <div class="text-body mt-3">{{ book.description }}</div>

                <v-btn @click="onRent" variant="outlined mt-5" size="x-large">
                    wypożycz
                </v-btn>
            </v-col>
        </v-row>
    </Layout>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";
import Layout from "../layout/Base.vue";

const props = defineProps({
    book: Object,
});

const onRent = () => {
    Inertia.post(`/rent/${props.book.id}`);
};
</script>

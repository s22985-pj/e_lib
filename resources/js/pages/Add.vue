<template>
    <Layout>
        <form @submit.prevent="submit">
            <v-text-field v-model="title" label="Tytuł" />
            <v-text-field v-model="author" label="Autor" />
            <v-text-field v-model="publisher" label="Wydawnictwo" />
            <v-text-field v-model="description" label="Opis" />
            <v-file-input v-model="image" label="Zdjęcie"></v-file-input>
            <Datepicker v-model="release" />
            <v-btn type="submit" variant="outlined mt-5">Dodaj</v-btn>
        </form>
    </Layout>
</template>

<script setup>
import { ref, watch } from "vue";
import { Inertia } from "@inertiajs/inertia";
import { usePage } from "@inertiajs/inertia-vue3";
import Layout from "../layout/Base.vue";
import { intervalToDuration } from "date-fns";

const page = usePage();
const title = ref();
const author = ref();
const publisher = ref();
const description = ref();
const image = ref();
const release = ref(new Date());

console.log(page.props.value.errors);

const submit = () => {
    Inertia.post("/create", {
        title: title.value,
        author: author.value,
        publisher: publisher.value,
        description: description.value,
        image: image.value,
        release: release.value.toISOString(),
        
    }); 
};
</script>

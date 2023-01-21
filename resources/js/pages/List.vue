<template>
    <Layout>
        <v-alert v-show="message.show" :color="message.type" class="mb-5">
            {{message.message}}
        </v-alert>
        <v-row>
            <v-col v-for="item in books" cols="3">
                <v-card @click="() => onShow(item)">
                    <v-img height="250" :src="item.image"></v-img>
                    <v-card-title>{{ item.title }}</v-card-title>
                    <v-card-subtitle>{{ item.author }}</v-card-subtitle>

                    <v-card-text class="description">
                        {{ item.description }}
                    </v-card-text>
                </v-card>

                <v-card-actions v-if="user.is_admin">
                    <v-spacer></v-spacer>
                    <v-btn
                        @click="() => onUnrent(item)"
                        variant="flat"
                        color="success"
                        v-if="item.user_id"
                    >
                        Zwrócona
                    </v-btn>
                    <v-btn
                        @click="() => onDestroy(item)"
                        variant="flat"
                        color="error"
                    >
                        Usuń
                    </v-btn>
                    <!-- <v-btn variant="flat" color="primary"> Edytuj </v-btn> -->
                    <v-spacer></v-spacer>
                </v-card-actions>
                <div v-if="item.user" class="text-center">
                    wypożyczone przez:
                    <span class="text-blue"> {{ item.user.name }}</span>
                </div>
            </v-col>
        </v-row>
    </Layout>
</template>

<script setup>
import { computed, onMounted, reactive,} from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
import Layout from "../layout/Base.vue";
import { Inertia } from "@inertiajs/inertia";

const page = usePage();

const user = computed(() => page.props.value.auth.user);
defineProps({
    books: Array,
});

const message = reactive({
    show: false,
    message: "",
    type: "",
})

onMounted(() => {
    showMessage()
})

const onShow = (item) => {
    Inertia.get(`/item/${item.id}`);
};

const onDestroy = (item) => {
    Inertia.delete(`/item/${item.id}`);
};

const onUnrent = (item) => {
    Inertia.post(`/unrent/${item.id}`, null);
};


const showMessage = ( ) => { 
    const props = page.props.value;
    if(props.message){ 
        message.message = props.message;
        message.type = "info";
        message.show = true;
    }
    if(props.errors.message){ 
        message.message = props.errors.message;
        message.type = "error";
        message.show = true;
    }
    console.log(page.props.value);

    setTimeout(() => {
        message.show = false;
    },5000)
}


</script>

<style>
.description {
    display: -webkit-box;
    overflow: hidden;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    height: 79px;
    margin-bottom: 10px;
}
</style>

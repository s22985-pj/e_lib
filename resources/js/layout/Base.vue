<template>
    <v-app id="inspire">
        <v-app-bar flat>
            <v-container class="fill-height d-flex align-center">
                <v-avatar class="mr-10 ml-4" color="grey-darken-1" size="32"></v-avatar>

                <Link href="/list">
                <v-btn variant="text"> Panel </v-btn>
                </Link>

                <Link href="/account">
                <v-btn variant="text"> Konto </v-btn>
                </Link>


                <v-btn @click="dialog = true" variant="text"> Oddaj </v-btn>

                <Link href="/add" v-if="user.is_admin">
                <v-btn variant="text"> Dodaj </v-btn>
                </Link>
                <v-spacer></v-spacer>
                <v-btn @click="onLogout" variant="text"> Wyloguj </v-btn>
            </v-container>
        </v-app-bar>

        <v-main class="bg-grey-lighten-3">
            <v-container>
                <v-row>
                    <v-col cols="2">
                        <v-sheet rounded="lg">
                            <v-list rounded="lg">
                                <v-list-subheader>
                                    Twoje książki
                                </v-list-subheader>
                                <v-list-item v-for="item in books" :key="item.id" link>
                                    <v-list-item-title>
                                        {{ item.id }}
                                        {{ item.title }}
                                    </v-list-item-title>
                                </v-list-item>
                            </v-list>
                        </v-sheet>
                    </v-col>

                    <v-col cols="10">
                        <v-sheet rounded="lg">
                            <div class="px-5 py-5">
                                <slot />
                            </div>
                        </v-sheet>
                    </v-col>
                </v-row>
            </v-container>

            <v-dialog v-model="dialog" width="500">
                <v-card>
                    <v-card-title class="text-h5 bg-grey-lighten-2">
                       Oddaj książke
                    </v-card-title>

                    <v-img :src="Scan"/>
                    <v-card-text>
                        <input @keydown.enter="onReturn" type="text"  />
                    </v-card-text>

                    <v-divider></v-divider>

                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="primary" text @click="dialog = false">
                            Anuluj
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-main>
    </v-app>
</template>

<script setup>
import Scan from "../../assets/scan.png";
import { computed, ref } from "vue";                // framework vue // ref aktualizacja frontu na bieżąco 
import { Link } from "@inertiajs/inertia-vue3";     // ahref dla vue
import { usePage } from "@inertiajs/inertia-vue3";  // 
import { Inertia } from "@inertiajs/inertia";       // Komunikacja Front-BackEnd 


const dialog = ref(false);
const user = computed(() => usePage().props.value.auth.user);
const books = computed(() => usePage().props.value.auth.books);

const onLogout = () => {
    Inertia.post("logout");
    
};

const onReturn = (event) => {
    dialog.value = false;

    Inertia.post(`/unrent/${ parseInt(event.target.value) }`, null);
};

</script>

<style>
.v-btn--fab {
    bottom: 0;
    right: 0;
    position: absolute;
    margin: 0 0 16px 16px;
}
</style>

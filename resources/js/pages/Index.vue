<template>
    <v-app id="inspire">
        <v-main>
            <v-container class="h-100">
                <div
                    class="flex flex-column justify-center items-center w-100 h-100"
                >
                    <div class="text-h1 text-center">Zeskanuj kod</div>
                    <img
                        class="d-block h-75 w-auto mt-5"
                        src="../../assets/searching.svg"
                    />
                    <input
                        class="opacity-0"
                        type="text" autofocus
                        @keydown.enter="onAuth"
                    /> <!-- wywołanie funkcji -->
                </div>
            </v-container>
        </v-main>
    </v-app>
</template>

<script setup>
import { Inertia } from "@inertiajs/inertia";

const onAuth = (event) => {
    Inertia.post("barcode-login", { barcode: event.target.value });
};
</script>

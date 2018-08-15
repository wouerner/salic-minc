<template>
    <div id="app">
        <v-app>
            <v-container fluid grid-list-xl>
                <v-layout wrap align-center>
                    <router-view></router-view>
                </v-layout>
            </v-container>
        </v-app>
    </div>
</template>

<script>
    export default {
        name: 'Index',
    };
</script>

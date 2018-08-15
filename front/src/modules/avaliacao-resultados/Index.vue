<template>
    <div id="app">
        <v-app>
            <v-container fluid>
              <v-layout wrap>
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

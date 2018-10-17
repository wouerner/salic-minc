<template>
    <div id="app">
        <v-app>
            <SlNav></SlNav>
            <v-content>
                <v-container fluid>
                  <v-layout>
                    <router-view></router-view>
                  </v-layout>
                </v-container>
            </v-content>
            <Rodape></Rodape>
      </v-app>
    </div>
</template>

<script>
    import Rodape from '@/components/rodape';
    import SlNav from './components/SlNav';

    export default {
        name: 'Index',
        components: { SlNav, Rodape },
    };
</script>

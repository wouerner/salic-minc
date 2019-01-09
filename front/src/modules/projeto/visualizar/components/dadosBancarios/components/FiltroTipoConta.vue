<template>
    <div>
        <template>
            <v-container fluid>
                <v-layout>
                    <v-flex xs4>
                        <v-select
                            v-model="search"
                            :items="tpConta"
                            item-text="text"
                            item-value="id"
                            label="Tipo Conta"
                        ></v-select>
                    </v-flex>
                </v-layout>
            </v-container>
        </template>
    </div>
</template>
<script>

    export default {
        name: 'FiltroTipoConta',
        data() {
            return {
                search: '',
                tpConta: [
                    {
                        id:'Captação',
                        text:'Captação'
                    },
                    {
                        id:'Movimentação',
                        text:'Movimentação'
                    },
                    {
                        id:'',
                        text:'Todos'
                    }
                ],
            };
        },
        watch: {
            search(val) {
                this.$emit('eventoSearch', val)
            },
        },
    };
</script>

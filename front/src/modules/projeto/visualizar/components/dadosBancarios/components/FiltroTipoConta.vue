<template>
    <div>
        <template>
            <v-container fluid>
                <v-layout>
                    <v-flex xs4>
                        <v-combobox
                                v-model="search"
                                :items="items"
                                label="Tipo da Conta"
                                chips
                                solo
                        >
                            <template
                                    slot="selection"
                                    slot-scope="data"
                            >
                                <v-chip
                                        :selected="data.selected"
                                        :disabled="data.disabled"
                                        :key="JSON.stringify(data.item)"
                                        class="v-chip--select-multi"
                                        @input="data.parent.selectItem(data.item)"
                                >
                                    <v-avatar
                                            class="primary white--text"
                                            v-text="data.item.slice(0, 1).toUpperCase()"
                                    ></v-avatar>
                                    {{ data.item }}
                                </v-chip>
                            </template>
                        </v-combobox>
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
                items: [
                    'Captação',
                    'Movimentação',
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

<template>
    <div>
        <span v-if="validaCampo().desc !== ''" color="alert">
            <div v-if="validaCampo().id === 1">
                <v-alert
                        :value="true"
                        type="warning"
                        class="black--text"
                >
                    {{ validaCampo().desc }}
                </v-alert>
            </div>
        </span>
        <template>
            <v-container fluid>
                <v-layout row wrap>
                    <v-flex xs12 sm6 md3>
                        <v-menu
                                ref="menu"
                                :close-on-content-click="false"
                                v-model="menu"
                                :nudge-right="40"
                                lazy
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                        >
                            <v-text-field
                                    slot="activator"
                                    v-model="datestring"
                                    label="Escolha a data inicial da Pesquisa"
                                    prepend-icon="event"
                                    @blur="date = parseDate(datestring)"
                                    mask="##/##/####"
                                    return-masked-value
                            ></v-text-field>
                            <v-date-picker
                                    class="calendario-vuetify"
                                    :max="new Date().toISOString().substr(0, 10)"
                                    v-model="date"
                                    scrollable
                                    locale="pt-br"
                                    @input="menu = false"
                                    color="primary lighten-1"
                            >
                            </v-date-picker>
                        </v-menu>
                    </v-flex>

                    <v-flex xs12 sm6 md3>
                        <v-menu
                                ref="menuFim"
                                :close-on-content-click="false"
                                v-model="menuFim"
                                :nudge-right="40"
                                lazy
                                transition="scale-transition"
                                offset-y
                                full-width
                                min-width="290px"
                                class="pl-4"
                        >
                            <v-text-field
                                    slot="activator"
                                    v-model="datestringFim"
                                    label="Escolha a data Final da Pesquisa"
                                    prepend-icon="event"
                                    @blur="dateFim = parseDate(datestringFim)"
                                    mask="##/##/####"
                                    return-masked-value
                            ></v-text-field>
                            <v-date-picker
                                    class="calendario-vuetify"
                                    :max="new Date().toISOString().substr(0, 10)"
                                    v-model="dateFim"
                                    scrollable
                                    locale="pt-br"
                                    @input="menuFim = false"
                                    color="primary lighten-1"
                            >
                            </v-date-picker>
                        </v-menu>
                    </v-flex>
                    <div class="pt-4 pl-4">
                        <v-btn color="teal" class="white--text" :disabled="!validaCampo().validacao"
                               @click="filtrarData()">Pesquisar
                        </v-btn>
                    </div>
                </v-layout>
            </v-container>
        </template>
    </div>
</template>
<script>

    export default {
        name: 'FiltroData',
        data() {
            return {
                date: '',
                menu: false,
                datestring: '',
                dateFim: '',
                menuFim: false,
                datestringFim: '',
            };
        },
        watch: {
            date(val) {
                this.datestring = this.formatDate(val);
            },
            dateFim(val) {
                this.datestringFim = this.formatDate(val);
            },
        },
        methods: {
            formatDate(date) {
                if (!date) return null;

                const [year, month, day] = date.split('-');
                return `${day}/${month}/${year}`
            },
            parseDate(date) {
                if (!date) return null;

                const [day, month, year] = date.split('/');
                return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
            },
            filtrarData() {
                const params = {
                    dtInicio: this.date,
                    dtFim: this.dateFim,
                };
                this.$emit('eventoFiltrarData', params);
            },
            validaCampo() {
                let status = {
                    desc: '',
                    validacao: false,
                    id: 0
                };
                if (this.date === '' && this.dateFim === '') {
                    status = { desc: '', validacao: false, id: 2 };
                    return status;
                }
                if (this.date === '' && this.dateFim !== '') {
                    status = { desc: 'Escolha a data inicial', validacao: false, id: 1 };
                    return status;
                } else if (this.date !== '' && this.dateFim === '') {
                    status = { desc: 'Escolha a data final', validacao: false, id: 1 };
                    return status;
                }
                if (this.date === this.dateFim) {
                    status = { desc: '', validacao: true, id: 3 };
                    return status;
                }
                if (this.date !== '' && this.dateFim !== '') {
                    if (Date.parse(this.date) > Date.parse(this.dateFim)) {
                        status = {
                            desc: 'Data Inicial não pode ser mais recente que a Data Final',
                            validacao: false,
                            id: 1
                        };
                        return status;
                    } else if (!(Date.parse(this.date) < Date.parse(this.dateFim))) {
                        status = {
                            desc: 'Data Final não pode ser anterior da Data Inicial',
                            validacao: false,
                            id: 1
                        };
                        return status;
                    }
                }
                status = { desc: 'tudo certo', validacao: true, id: 3 };
                return status;
            },
        },
    };
</script>

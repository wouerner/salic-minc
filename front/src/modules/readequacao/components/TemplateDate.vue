<template>
    <v-container fluid>
        <v-layout row wrap>
            <v-flex xs10 md5>
                <v-card height="140px">
                    <v-card-title class="grey lighten-2">Versão original</v-card-title>
                    <v-divider/>
                    <v-card-text>
                        {{ campo.valor }}
                    </v-card-text>
                </v-card>
            </v-flex>
            <v-flex
                xs10
                md5
                offset-md2
                >
                <v-card
                  height="140px"
                  >
                    <v-card-title
                        class="green lighten-2"
                        >
                        Versão readequada
                    </v-card-title>
                    <v-card-actions>
                        <v-menu
                            ref="menu"
                            v-model="menu"
                            :close-on-content-click="false"
                            :nudge-right="40"
                            lazy
                            transition="scale-transition"
                            offset-y
                            full-width
                            max-width="290px"
                            min-width="290px"
                            >
                            <v-text-field
                                slot="activator"
                                v-model="dateFormatted"
                                label="Date"
                                hint="Formato DD/MM/YYYY"
                                persistent-hint
                                prepend-icon="event"
                                ></v-text-field>
                            <v-date-picker
                                v-model="date"
                                no-title
                                @input="menu = false"
                                >
                            </v-date-picker>
                        </v-menu>
                    </v-card-actions>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
</template>
<script>
export default {
    name: 'TemplateDate',
    props: {
        campo: { type: Object, default: () => {} }
    },
    data() {
        return {
            date: '',
            dateFormatted: '',
            menu: false,
        };
    },
    watch: {
        date(val) {
            this.$emit('data-update', this.date);
            this.dateFormatted = this.formatDate(this.date);
        },
    },
    computed: {
        computedDateFormatted() {
            dataFormatada = this.formatDate(this.date);
            return dataFormatada;
        },
    },
    created() {
        this.date = this.campo.valor.substr(0, 10);
    },
    methods: {
        formatDate(date) {
            if (!date) return null
            let [year, month, day] = date.split('-');
            return `${day}/${month}/${year}`;
        },
        parseDate(date) {
            if (!date) return null;
            let [month, day, year] = date.split('/')
            return `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`
        },
    },
};
</script>

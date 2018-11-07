<template>

    <v-layout row justify-center>
        <v-dialog v-model="dialog" scrollable max-width="800px">
            <v-btn slot="activator" color="cyan" dark><v-icon>assignment_late</v-icon></v-btn>
            <v-card>
                <v-card-title>Histórico Diligências</v-card-title>
                <v-divider></v-divider>
                <v-card-text style="height: 300px;">
                    <v-timeline>
                        <v-timeline-item
                            v-for="(year, i) in years"
                            :color="year.color"
                            :key="i"
                            small
                        >
                              <span
                                  slot="opposite"
                                  :class="`headline font-weight-bold ${year.color}--text`"
                                  v-text="year.year">
                              </span>
                            <div class="py-3">
                                <h2 :class="`headline font-weight-light mb-3 ${year.color}--text`">Lorem ipsum </h2>
                                <div>
                                    Lorem ipsum dolor sit amet, no nam oblique veritus. Commune scaevola imperdiet nec ut, sed euismod convenire principes at. Est et nobis iisque percipit, an vim zril disputando voluptatibus, vix an salutandi sententiae.
                                </div>
                            </div>
                        </v-timeline-item>
                    </v-timeline>
                </v-card-text>
                <v-divider></v-divider>
                <v-card-actions>
                    <v-btn color="blue darken-1" flat @click.native="dialog = false">Close</v-btn>
                    <v-btn color="blue darken-1" flat @click.native="dialog = false">Save</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>

</template>

<script>
export default {
    name: 'HistoricoDiligencias',
    props: { data: Object },
    data() {
        return {
            dialog: false,
            years: [
                {
                    color: 'cyan',
                    year: '1960',
                },
                {
                    color: 'green',
                    year: '1970',
                },
                {
                    color: 'pink',
                    year: '1980',
                },
                {
                    color: 'amber',
                    year: '1990',
                },
                {
                    color: 'orange',
                    year: '2000',
                },
            ],
        };
    },
    methods: {
        show() {
            console.info('oi' + this.data);
        },
    },
    mounted() {
        this.show();
    },
};
</script>

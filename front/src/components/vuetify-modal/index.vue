<template>
    <!--<div class="text-xs-center">-->
        <!--<v-dialog-->
            <!--v-model="dialog"-->
            <!--width="500"-->
        <!--&gt;-->
            <!--<v-card>-->
                <!--<v-card-title-->
                    <!--class="headline grey lighten-2"-->
                    <!--primary-title-->
                <!--&gt;-->
                    <!--<slot name="header">Header</slot>-->
                <!--</v-card-title>-->

                <!--<v-card-text>-->
                    <!--<slot name="body">Body</slot>-->
                <!--</v-card-text>-->

                <!--<v-divider></v-divider>-->

                <!--<v-card-actions>-->
                    <!--<slot name="footer">-->
                        <!--<v-spacer></v-spacer>-->
                        <!--<v-btn-->
                            <!--color="primary"-->
                            <!--flat-->
                            <!--@click="fecharModal();"-->
                        <!--&gt;-->
                            <!--I accept-->
                        <!--</v-btn>-->
                    <!--</slot>-->
                <!--</v-card-actions>-->
            <!--</v-card>-->
        <!--</v-dialog>-->
    <!--</div>-->

    <v-layout row justify-center>
        <v-dialog v-model="dialog" persistent max-width="290">
            <v-btn slot="activator" color="primary" dark>Open Dialog</v-btn>
            <v-card>
                <v-card-title class="headline">
                    <slot name="header">Header</slot>
                </v-card-title>
                <v-card-text>
                    <slot name="body">Body</slot>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <slot name="footer">
                        <v-btn color="green darken-1" flat @click="fecharModal()">Disagree</v-btn>
                        <v-btn color="green darken-1" flat @click="fecharModal()">Agree</v-btn>
                    </slot>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-layout>
</template>

<script>
    import { mapActions } from 'vuex';

    export default {
        data() {
            return {
                dialog: false,
            };
        },
        mounted() {
            // const objeto = this;
            // // eslint-disable-next-line
            // $3('.modal').modal({ complete: () => { objeto.fecharModal(); } });
            //
            // // eslint-disable-next-line
            // $3('#modalTemplate').modal('open');
        },
        methods: {
            fecharModal() {
                // // eslint-disable-next-line
                // $3('#modalTemplate')
                //     .modal('close');
                // this.$emit('close');
                this.modalClose();
                this.dialog = false;
            },
            ...mapActions({
                modalClose: 'modal/modalClose',
            }),
        },
    };
</script>

<template>
    <v-card>
        <v-card-title class="headline ">
            Buscar projeto
        </v-card-title>
        <v-card-text>
            <v-autocomplete
                v-model="model"
                :items="items"
                :loading="isLoading"
                :search-input.sync="campoDeBusca"
                hide-no-data
                hide-selected
                color="black"
                item-text="Description"
                item-value="API"
                label="Projetos"
                placeholder="Escreva o pronac ou nome do projeto"
                prepend-icon="mdi-database-search"
                return-object
            ></v-autocomplete>
        </v-card-text>
        <v-divider></v-divider>
        <v-expand-transition>
            <v-list v-if="model" class="red lighten-3">
                <v-list-tile
                    v-for="(field, i) in fields"
                    :key="i"
                >
                    <v-list-tile-content>
                        <v-list-tile-title v-text="field.value"></v-list-tile-title>
                        <v-list-tile-sub-title v-text="field.key"></v-list-tile-sub-title>
                    </v-list-tile-content>
                </v-list-tile>
            </v-list>
        </v-expand-transition>
        <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn
                :disabled="!model"
                @click="model = null"
            >
                Clear
                <v-icon right>mdi-close-circle</v-icon>
            </v-btn>
        </v-card-actions>
    </v-card>
</template>

<script>
    import axios from 'axios';
    import _ from 'lodash';

    export default {
        name: 'buscarProjeto',
        data: () => ({
            descriptionLimit: 60,
            entries: [],
            isLoading: false,
            model: null,
            campoDeBusca: null,
        }),
        computed: {
            fields() {
                if (!this.model) return [];

                return Object.keys(this.model).map((key) => {
                    return {
                        key,
                        value: this.model[key] || 'n/a',
                    };
                });
            },
            items() {
                return this.entries.map((entry) => {
                    let Description = entry.NomeProjeto.length > this.descriptionLimit
                        ? `${entry.NomeProjeto.slice(0, this.descriptionLimit)} ...`
                        : entry.NomeProjeto;
                    Description = `${entry.Pronac} - ${Description}`;
                    return Object.assign({}, entry, { Description });
                });
            },
        },
        created() {
            this.debouncedObterProjetos = _.debounce(this.buscarProjetos, 500);
        },
        watch: {
            campoDeBusca() {
                this.debouncedObterProjetos();
            },
        },
        methods: {
            buscarProjetos() {
                // Items have already been loaded
                if (this.campoDeBusca.length < 5) return;

                // Items have already been requested
                if (this.isLoading) return;

                this.isLoading = true;
                const self = this;

                axios.get(`/navegacao/projeto-rest/?pronac=${self.campoDeBusca}`)
                    .then((response) => {
                        const { count, projetos } = response.data;
                        this.count = count;
                        this.entries = projetos;
                    })
                    .catch((error) => {
                        console.log(error);
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            },
        },
    };
</script>

<style scoped>

</style>

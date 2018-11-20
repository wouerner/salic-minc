<template>
    <div>
        <v-card-title>
            <v-spacer></v-spacer>
            <v-text-field
                v-model="search"
                append-icon="search"
                label="Pesquisar"
                single-line
                hide-details
                ></v-text-field>
        </v-card-title>
        <v-data-table
            :headers="cab()"
            :items="dados.items"
            :pagination.sync="pagination"
            hide-actions
            :search="search"
        >
            <template slot="items" slot-scope="props">
                <td>{{ props.index+1 }}</td>
                <td class="text-xs-right">
                    <v-flex xs12 sm4 text-xs-center>
                        <div>
                            <v-btn flat :href="'/projeto/#/'+ props.item.idPronac">{{ props.item.PRONAC }}</v-btn>
                        </div>
                    </v-flex>
                </td>
                <td class="text-xs-left">{{ props.item.NomeProjeto }}</td>
                <td class="text-xs-center">{{ props.item.Situacao }}</td>
                <td class="text-xs-center">{{ props.item.UfProjeto }}</td>
                <td class="text-xs-center" v-if="mostrarTecnico">{{ props.item.usu_nome }}</td>
                <td class="text-xs-center">
                    <template v-for="(c, index) in componentes.acoes" d-inline-block>
                        <component
                            v-bind:key="index"
                            :status="statusDiligencia(props.item)"
                            :is="c"
                            :id-pronac="props.item.IdPRONAC"
                            :pronac="props.item.PRONAC"
                            :nome-projeto="props.item.NomeProjeto"
                            :atual="componentes.atual"
                            :proximo="componentes.proximo"
                            :idTipoDoAtoAdministrativo="componentes.idTipoDoAtoAdministrativo"
                            :usuario="componentes.usuario"
                        >
                        </component>
                    </template>
                </td>
            </template>
            <template slot="no-data">
                <v-alert :value="true" color="error" icon="warning">
                    Nenhum dado encontrado ¯\_(ツ)_/¯
                </v-alert>
            </template>
        </v-data-table>
        <div class="text-xs-center">
            <div class="text-xs-center pt-2">
                <v-pagination
                    v-model="pagination.page"
                    :length="pages"
                    :total-visible="4"
                    color="primary "
                ></v-pagination>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';

    export default {
    name: 'TabelaProjetos',
    props: ['dados', 'componentes', 'mostrarTecnico'],
    data() {
        return {
            pagination: {
                rowsPerPage: 10,
            },
            selected: [],
            search: '',
            cabecalho: [
                {
                    text: '#',
                    align: 'left',
                    sortable: false,
                    value: 'numero',
                },
                {
                    text: 'PRONAC',
                    value: 'Pronac',
                    align: 'center',
                },
                {
                    text: 'Nome Do Projeto',
                    align: 'center',
                    value: 'NomeProjeto',
                },
                {
                    text: 'Situacao',
                    align: 'center',
                    value: 'Situacao',
                },
                {
                    text: 'Estado',
                    align: 'center',
                    value: 'UfProjeto',
                },
                {
                    text: 'Tecnico',
                    align: 'center',
                    value: '',
                },
                {
                    text: 'Ações',
                    sortable: false,
                    align: 'center',
                },
            ],
        };
    },
    methods: {
        ...mapActions({
            obterDadosTabelaTecnico: 'avaliacaoResultados/obterDadosTabelaTecnico',
        }),
        cab() {
            let dados = [];

            dados = [
                {
                    text: '#',
                    align: 'left',
                    sortable: false,
                    value: 'numero',
                },
                {
                    text: 'PRONAC',
                    value: 'Pronac',
                },
                {
                    text: 'Nome Do Projeto',
                    align: 'center',
                    value: 'NomeProjeto' },
                {
                    text: 'Situacao',
                    align: 'center',
                    value: 'Situacao',
                },
                {
                    text: 'Estado',
                    align: 'center',
                    value: 'UfProjeto',
                },
            ];

            if (this.mostrarTecnico) {
                dados[5] = {
                    text: 'Tecnico',
                    align: 'center',
                    value: '',
                };
            }

            dados[6] = {
                text: 'Ações',
                sortable: false,
                align: 'center',
            };

            return dados;
        },
        statusDiligencia(obj){

            let prazo = this.prazoResposta(obj);
            let status = {
                    color:'grey',
                    desc: 'Histórico Diligências'
              };
            let prazoPadrao = 40;
            //
            //
            // if(obj.idDiligencia == 58455){
            //   console.info(obj.idDiligencia+" - " + obj.DtSolicitacao + " / " + obj.stEnviado + " - "+ obj.DtResposta);
            //   status.color='blue'
            //   status.desc= 'Diliganciado';
            //     return status;
            // }
            //
            // if(obj.idDiligencia == 53257){
            //     console.info(obj.idDiligencia+" - " + obj.DtSolicitacao + " / " + obj.stEnviado + " - "+ obj.DtResposta);
            //     status.color='red'
            //     status.desc= 'Não respondido';
            //     return status;
            // }
            //
            // if(obj.idDiligencia == 51863){
            //     console.info(obj.idDiligencia+" - " + obj.DtSolicitacao + " / " + obj.stEnviado + " - "+ obj.DtResposta);
            //     status.color='green'
            //     status.desc= 'Diligencia respondida';
            //     return status;
            // }

            //diligenciado
             if (obj.DtSolicitacao && obj.dtResposta == null && prazo <= prazoPadrao && stEnviado == 'S') {
                 return status = { color: 'green', desc: "Diligenciado" };


            //diligencia não respondida
              }else if( obj.DtSolicitacao && obj.dtResposta == null && prazo > prazoPadrao ){
                 status.desc="Diligência não respondida";
                 return status;
            //diligencia respondida com ressalvas
                 }else if( obj.DtSolicitacao && obj.dtResposta != null ) {
                    if( obj.stEnviado == 'N' && prazo > prazoPadrao ){
                        status.desc="Diligência não respondida";
                        return status;
                    }else if(obj.stEnviado =='N' && prazo < prazoPadrao){
                        status.desc="Diligenciado";
                        return status;
                    }else{
                        status.desc="Diligencia respondida";
                        return status;
                    }
                 }else{
                        status.desc="A Diligenciar";
                        return status;
                 }
            if(obj.idPronac === '1410398') {
                console.info(obj);
            }


        },
        prazoResposta(obj){
            /**
             If (notempty dtSolicitação){
             Calculo do Prazo

             prazo = date.now() - datainicial(dtSolicitacao);

              converter.dias(prazo)

             -> Para casos de de ser contagem regressiva.
             if (key boolean (bln_descrescente) ){
              prazo = prazoPadrao - prazo(do calculo acima);
             }

             if(prazo > 0) { prazo positivo
              return prazo
             } else if( prazo <= 0) { prazo negativo
                return 0
             } else {        para prazo de resposta igual ao padrão
              return -1
             }
             }else {
             return 0
             }
             */

            if(typeof obj.DtSolicitacao !== undefined){

                var coisa = Date.now();
                var timeDiff = Math.abs(coisa - new Date(obj.DtSolicitacao));
                var prazo = Math.ceil(timeDiff / (1000 * 3600 * 24));
                console.info(new Date().toLocaleDateString(undefined, {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                }) + " - "+ new Date(obj.DtSolicitacao).toLocaleDateString(undefined, {
                    day: '2-digit',
                    month: '2-digit',
                    year: 'numeric'
                }) + " = "+ prazo);

                if(prazo > 0) { //prazo positivo
                    return prazo
                } else if( prazo <= 0) { //prazo negativo
                    return 0
                } else {        //para prazo de resposta igual ao padrão
                    return -1
                }
            }else {
                return 0
            }
        },
    },
    computed: {
        ...mapGetters({
            dadosTabelaTecnico: 'avaliacaoResultados/dadosTabelaTecnico',
        }),
        pages() {
            if (this.pagination.rowsPerPage == null ||
                this.pagination.totalItems == null
            ) return 0;
            return Math.ceil(this.pagination.totalItems / this.pagination.rowsPerPage);
        },
    },
    watch: {
        dadosTabelaTecnico() {
            if (this.dados.items !== undefined) {
                this.pagination.totalItems = this.dados.items.length;
            }
        },
    },
    mounted(){
        this.dadosTabelaTecnico;
    }
};
</script>

<template>
    <div>
        <table>
            <thead>
                <tr>
                    <th>N&ordm;</th>
                    <th>Proposta/Projeto</th>
                    <th>Solicita&ccedil;&atilde;o</th>
                    <th>Estado</th>
                    <th>Dt. Solicita&ccedil;&atilde;o</th>
                    <th>Dt. Resposta</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(dado, index) in dados" :key="index">
                    <div>
                        <td>{{ dado.idProjeto }}</td>
                        <td>{{ dado.NomeProjeto }}</td>
                        <td>{{ dado.dsSolicitacao }}</td>
                        <td>{{ dado.dsEncaminhamento }}</td>
                        <td>{{ dado.dtSolicitacao }}</td>
                        <td>{{ dado.dtResposta }}</td>
                        <td>
                            <div class="btn blue small white-text tooltipped" data-tooltip="Visualizar" @click="setActiveTab(index);">
                                <i class="material-icons">visibility</i>
                            </div>
                        </td>
                    </div>
                    <div v-if="activeTab === index">
                        Informaçao collapse
                    </div>
                </tr>
            </tbody>
        </table>
    </div>
</template>
<script>

export default {
    name: 'PropostaHistoricoSolicitacoes',
    data() {
        return {
            dados: [],
            activeTab: -1,
        };
    },
    props: ['idpreprojeto'],
    mounted() {
        if (typeof this.idpreprojeto !== 'undefined') {
            this.fetch(this.idpreprojeto);
        }
    },
    watch: {
        idpreprojeto(value) {
            this.fetch(value);
        },
    },
    methods: {
        setActiveTab(index) {
            if (this.activeTab === index) {
                this.activeTab = -1;
            } else {
                this.activeTab = index;
            }
        },
        fetch(id) {
            if (id) {
                const self = this;
                /* eslint-disable */
                $3.ajax({
                    url: '/solicitacao/mensagem-rest/historico-solicitacoes/idPreProjeto/' + 282175
                }).done(function (response) {
                    console.log(response.data);
                    self.dados = response.data.items;
                });
            }
        },
    }
};
</script>

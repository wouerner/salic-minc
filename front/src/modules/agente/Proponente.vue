<template>
    <div id="proponente">
        <Carregando v-if="loading" :text="'Procurando proponente'"></Carregando>
        <div v-if="Object.keys(proponente).length > 0">
            <div v-if="identificacao" class="card">
                <div class="card-content">
                    <h5>Identifica&ccedil;&atilde;o</h5>

                    <div class="row">
                        <div class="col s12 l4 m4">
                            <b>CNPJ/CPF</b><br>
                            {{ identificacao.cnpjcpf }}
                        </div>
                        <div class="col s12 l4 m4">
                            <b>Nome Proponente</b><br>
                            {{ identificacao.descricao }}
                        </div>
                        <div class="col s12 l4 m4">
                            <b>Tipo de Pessoa</b><br>
                            {{ TipoPessoa }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <h5>Endere&ccedil;o</h5>
                    <table v-if="proponente.enderecos" class="bordered responsive-table">
                        <thead>
                        <tr>
                            <th>Tipo de Endere&ccedil;o</th>
                            <th>Tipo do Logradouro</th>
                            <th>Logradouro</th>
                            <th>N&uacute;mero</th>
                            <th>Complemento</th>
                            <th>Bairro</th>
                            <th>Cidade</th>
                            <th>UF</th>
                            <th>CEP</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="endereco in proponente.enderecos">
                            <td>{{ endereco.tipoendereco }}</td>
                            <td>{{ endereco.dstipologradouro }}</td>
                            <td>{{ endereco.logradouro }}</td>
                            <td>{{ endereco.numero }}</td>
                            <td>{{ endereco.complemento }}</td>
                            <td>{{ endereco.bairro }}</td>
                            <td>{{ endereco.municipio }}</td>
                            <td>{{ endereco.uf }}</td>
                            <td>{{ endereco.cep }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <h5>Telefones</h5>
                    <table v-if="proponente.telefones" class="bordered responsive-table">
                        <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>UF</th>
                            <th>DDD</th>
                            <th>N&uacute;mero</th>
                            <th>Pode Divulgar?</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="telefone in proponente.telefones">
                            <td>{{ telefone.dstelefone }}</td>
                            <td>{{ telefone.ufsigla }}</td>
                            <td>{{ telefone.ddd }}</td>
                            <td>{{ telefone.numero }}</td>
                            <td>{{ label_sim_ou_nao(telefone.divulgar) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <h5>E-mail</h5>
                    <table v-if="proponente.emails" class="bordered responsive-table">
                        <thead>
                        <tr>
                            <th>Tipo</th>
                            <th>E-mail</th>
                            <th>Pode divulgar?</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="email in proponente.emails">
                            <td nowrap>{{ email.tipo }}</td>
                            <td nowrap>{{ email.descricao }}</td>
                            <td>{{ label_sim_ou_nao(email.divulgar) }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <h5>Natureza</h5>
                    <table v-if="proponente.natureza && proponente.natureza.length > 0"
                           class="bordered responsive-table">
                        <thead>
                        <tr>
                            <th>Direito</th>
                            <th>Esfera</th>
                            <th>Poder</th>
                            <th>Administra&ccedil;&atilde;o</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>{{ proponente.natureza.direito }}</td>
                            <td>{{ proponente.natureza.esfera }}</td>
                            <td>{{ proponente.natureza.poder }}</td>
                            <td>{{ proponente.natureza.Admins }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div v-else>Natureza n&atilde;o informada</div>
                </div>
            </div>

            <div class="card">
                <div class="card-content">
                    <h5>Dirigentes</h5>
                    <table v-if="proponente.dirigentes && proponente.dirigentes.length > 0"
                           class="bordered responsive-table">
                        <thead>
                        <tr>
                            <th width="20%">CPF</th>
                            <th>Nome</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="dirigente in proponente.dirigentes">
                            <td align="center">{{ dirigente.cnpjcpfdirigente }}</td>
                            <td align="left">{{ dirigente.nomedirigente }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div v-else>N&atilde;o existem dirigentes cadastrados!</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Carregando from '@/components/Carregando';

    export default {
        name: "Proponente",
        data: function () {
            return {
                proponente: [],
                identificacao: [],
                loading: true,
            }
        },
        components: {
            Carregando
        },
        props: ['id', 'cpf'],
        mounted: function () {
            if (typeof this.id != 'undefined') {
                this.fetch(this.id);
            }

            if (typeof this.cpf != 'undefined') {
                this.fetch(null, this.cpf);
            }
        },
        watch: {
            id: function (value) {
                if (typeof value != 'undefined') {
                    this.fetch(this.id);
                }
            },
            cpf: function (value) {
                if (typeof value != 'undefined') {
                    this.fetch(null, value);
                }
            }
        },
        computed: {
            idusuario() {
                // We will see what `params` is shortly
                console.log(this.$route.params.idusuario);
                return this.$route.params.idusuario
            },
            TipoPessoa: function () {
                return this.label_tipo_pessoa(this.identificacao.tipopessoa);
            }
        },
        methods: {
            fetch: function (id = null, cpf = null) {
                let params = {}

                if (id) {
                    params = {idAgente: id};
                }

                if (cpf) {
                    params = {cpf: cpf};
                }

                let self = this;
                $3.ajax({
                    url: '/agente/visualizar/obter-dados-proponente/',
                    data: params
                }).done(function (response) {
                    self.proponente = response.data;

                    if (self.proponente && self.proponente.identificacao) {
                        self.identificacao = self.proponente.identificacao;
                    }

                    self.loading = false;
                                            
                });
            },
            label_tipo_pessoa: function (tipo) {
                let string = 'Pessoa Física';

                if (tipo == '1')
                    string = 'Pessoa Jurídica';

                return string;
            },
            label_sim_ou_nao: function (valor) {
                if (valor == 1)
                    return 'Sim';
                else
                    return 'Não';
            }
        }
    };
</script>
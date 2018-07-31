Vue.component('sl-comprovante-internacional-form',
{
    template: `
        <form>
            <fieldset>
                <legend>Dados da Comprova&ccedil;&atilde;o de Pagamento Internacional</legend>
                <div class="row">
                    <div class="col s4">
                        <label class="" for="pais">Nacionalidade do Fornecedor</label>
                        <select
                            v-model="comprovante.fornecedor.nacionalidade"
                            name="pais"
                            class=" browser-default "
                         >
                            <option v-for="p in pais" :value="p.id">
                                {{p.nome}}
                            </option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <input
                            v-model="comprovante.fornecedor.nome"
                            ref="nome"
                            type="text"
                            :class="[this.c.fornecedor.nome.css]"
                            v-on:input="inputNome($event.target.value)"
                        />
                        <label for="nomeRazaoSocialInternacional"
                            :class="['active', this.c.fornecedor.nome.css]"
                        >Nome da Empresa * </label>
                    </div>
                    <div class="input-field col s6">
                        <input
                            v-model="comprovante.fornecedor.endereco"
                            type="text"
                        />
                        <label for="enderecoInternacional">Endere&ccedil;o</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s5">
                        <input type="text" name="nif"
                            ref="numero"
                            v-model="comprovante.numero"
                            :class="[this.c.numero.css]"
                            v-on:input="inputNumero($event.target.value)"
                        />
                        <label
                            :class="[this.c.numero.css]"
                        > N&uacute;mero do documento * </label>
                    </div>
                    <div class="input-field col s4">
                        <input type="text" name="nrSerie"
                            id="nrSerie" maxlength="8"
                                v-model="comprovante.serie"
                               value=""/>
                        <label>S&eacute;rie</label>
                    </div>
                    <div class="col s3">
                        <p>
                            <label>Tipo de Documento</label>
                        </p>
                        <p>
                            <input type="radio" value="6"
                                id="tipo_documento_invoice"
                                v-model="comprovante.tipo"
                            />
                            <label for="tipo_documento_invoice">Invoice</label>
                        </p>
                        <p>
                            <input type="radio" value="7"
                                id="tipo_documento_outros"
                                    v-model="comprovante.tipo" />
                            <label for="tipo_documento_outros">Outros</label>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <input
                            ref="dataEmissao"
                            type="text"
                            name="dtEmissaoInternacional"
                            v-model="comprovante.dataEmissao"
                            :class="[this.c.dataEmissao.css]"
                            v-on:input="inputDataEmissao($event.target.value)"
                        />
                        <label for="dtEmissaoInternacional"
                            :class="[this.c.dataEmissao.css]"
                        >Dt. do Documento *</label>
                    </div>
                    <div class="input-field col s6">
                        <input
                            ref="dataPagamento"
                            type="text"
                            id="dtPagamentoInternacional"
                            v-model="comprovante.dataPagamento"
                            v-on:input="inputDataPagamento($event.target.value)"
                            :class="[this.c.dataPagamento.css]"
                        />
                        <label for="dtPagamentoInternacional"
                            :class="[this.c.dataPagamento.css]"
                        >Dt. do Pagamento *</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s4">
                        <input type="text" name="vlComprovadoInternacional"
                            ref="valor"
                            v-model="comprovante.valor"
                            :class="[this.c.valor.css]"
                            v-on:input="inputValor($event.target.value)"
                        size="10" value=""/>
                        <label for="vlComprovadoInternacional"
                            :class="[this.c.valor.css]"
                        >
                           Valor * (atual: {{valorantigo}})(max: {{(valorMaxItem)}})<span style='color:red'>*</span></label>
                        </label>
                    </div>
                    <div class="file-field input-field col s4">
                        <div :class="['btn small', c.arquivo.css] ">
                            <input name="arquivo" id="arquivo" ref="arquivo" type="file" @change="file">
                            <span>Arquivo *</span>
                        </div>
                        <div class="file-path-wrapper">
                            <input class="file-path validate" type="text"
                                   v-model="comprovante.arquivo.name"
                                placeholder="Selecionar arquivo">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                        <textarea id="dsJustificativaInternacionalId"
                            class="materialize-textarea" rows="5"
                            v-model="comprovante.justificativa"
                            name="dsJustificativaInternacional">
                        </textarea>
                        <label for="dsJustificativaInternacionalId">Justificativa</label>
                    </div>
                </div>
            </fieldset>
            <button type="button" class="btn" @click.prevent="salvar()">salvar</button>
            <button type="button" class="btn white black-text" @click="cancelar()">cancelar</button>
        </form>
    `,
    mounted: function() {
        this.paises();

        this.comprovante.item = this.item;
        if (this.dados) {
            if (this.dados.idComprovantePagamento) {
                this.comprovante.id = this.dados.idComprovantePagamento;
            }

            this.comprovante.id = this.dados.idComprovantePagamento;
            this.comprovante.fornecedor.nome = this.dados.fornecedor.nome;
            this.comprovante.fornecedor.endereco = this.dados.fornecedor.endereco;
            this.comprovante.fornecedor.id = this.dados.fornecedor.id;

            this.comprovante.numero = this.dados.numero;
            this.comprovante.serie = this.dados.nrSerie;
            this.comprovante.dataEmissao = moment(this.dados.dataEmissao).format('DD/MM/YYYY');
            this.comprovante.dataPagamento = moment(this.dados.dataPagamento).format('DD/MM/YYYY');
            this.comprovante.valor = this.dados.valor;
            this.comprovante.numeroDocumento = this.dados.nrDocumentoDePagamento;
            this.comprovante.arquivo = { name: this.dados.nmArquivo };
            this.comprovante.justificativa = this.dados.dsJustificativaProponente;
        }
    },
    props: ['dados', 'url', 'messages', 'tipoform', 'item', 'idplanilhaaprovacao',
        'index', 
        'datainicio', 
        'datafim',
        'valoraprovado',
        'valorcomprovado',
        'valorantigo'
    ],
    computed:{
        dataInicio() {
            return moment(this.datainicio).format('DD/MM/YYYY');
        },
        dataFim() {
            return moment(this.datafim).format('DD/MM/YYYY');
        },
        valorMaxItem: function() {
            return parseFloat(this.valoraprovado) - (parseFloat(this.valorcomprovado) - (this.valorantigo ? this.valorantigo : 0 ));
        }
    },
    data: function () {
        return {
            comprovante: {
                fornecedor: {
                    nacionalidade: 1,
                    tipoPessoa: 1,
                    CNPJCPF: '',
                    cnpjcpfMask: '',
                    nome: '',
                    idAgente: '',
                    eInternacional: true,
                    id: '',
                },
                item: this.item,
                idPlanilhaAprovacao: this.idplanilhaaprovacao,
                tipo: 1,
                numero: '',
                serie: '',
                dataEmissao: '',
                dataPagamento:'',
                forma: 1,
                numeroDocumento: '',
                valor: '',
                valorAntigo: this.valorantigo,
                arquivo: '',
                justificativa: '',
                foiAtualizado: false,
                _index: this.index
            },
            pais: '',
            c: {
                fornecedor: {
                    CNPJCPF: {
                        css:'',
                    },
                    nome: {
                        css:'',
                    },
                },
                numero: {
                    css: ''
                },
                serie: '',
                dataEmissao: {
                    css:'',
                },
                dataPagamento:{
                    css:'',
                },
                numeroDocumento: {
                    css:'',
                } ,
                valor: {
                    css:'',
                },
                arquivo: {
                    css: '',
                },
            },
            random: ''
        }
    },
    methods: {
        salvar: function() {
            if (this.validar()) {
                var vue = this;
                var url = this.url;

                let formData = new FormData();

                if (this.comprovante.foiAtualizado) {
                    formData.append('arquivo', this.comprovante.arquivo);
                }

                formData.append('comprovante', JSON.stringify(this.comprovante));

                $3.ajax({
                    url: url,
                    method: 'POST',
                    data: formData,
                    contentType: 'multipart/form-data',
                    processData: false,
                    contentType: false,
               }).done(function(data){
                    Materialize.toast('Salvo com sucesso!', 4000, 'green');
                    $3('#modal1').modal('close');

                    if (vue.tipoform == 'cadastro') {
                       vue.comprovante._index = data.idComprovantePagamento;
                       vue.comprovante.idComprovantePagamento = data.idComprovantePagamento;
                       vue.$root.$emit('novo-comprovante-internacional', vue.comprovante);

                       vue.c = {
                           fornecedor: {
                               CNPJCPF: {
                                   css:'',
                               },
                               nome: {
                                   css:'',
                               },
                           },
                           numero: {
                               css: ''
                           },
                           serie: '',
                           dataEmissao: {
                               css:'',
                           },
                           dataPagamento:{
                               css:'',
                           },
                           numeroDocumento: {
                               css:'',
                           } ,
                           valor: {
                               css:'',
                           },
                           arquivo: {
                               css: '',
                           },
                       }

                       vue.comprovantee = {
                            fornecedor: {
                                nacionalidade: '' ,
                                tipoPessoa: 1,
                                CNPJCPF: '',
                                cnpjcpfMask: '',
                                nome: '',
                                idAgente: '',
                                eInternacional: false,
                            },
                            item: vue.item,
                            tipo: 1,
                            numero: '',
                            serie: '',
                            dataEmissao: '',
                            dataPagamento:'',
                            forma: 1,
                            numeroDocumento: '',
                            valor: '',
                            arquivo: '',
                            justificativa: '',
                            foiAtualizado: false,
                        }
                    }

                    if (vue.tipoform == 'edicao'){
                        vue.$root.$emit('atualizado-comprovante-internacional', vue.comprovante);
                    }
                });
            }
        },
        validar: function() {

            if(!this.comprovante.fornecedor.nome) {
                this.$refs.nome.focus();
                this.c.fornecedor.nome.css = 'active invalid red-text';
                return false;
            }

            if(!this.comprovante.numero) {
                this.$refs.numero.focus();
                this.c.numero.css = 'active invalid red-text';
                return false;
            }
            if(!this.comprovante.dataEmissao) {
                this.$refs.dataEmissao.focus();
                this.c.dataEmissao.css = 'active invalid red-text';
                return false;
            }
            if(!this.comprovante.dataPagamento) {
                this.$refs.dataPagamento.focus();
                this.c.dataPagamento.css = 'active invalid red-text';
                return false;
            }

            if(!this.validarValor()) {
               return false;
            }

            // if(!this.comprovante.valor) {
            //     this.$refs.valor.focus();
            //     this.c.valor.css = 'active invalid red-text';
            //     return false;
            // }

            if(!this.comprovante.arquivo) {
                this.$refs.arquivo.focus();
                this.c.arquivo.css = 'active red';
                return false;
            }

            return true;
        },
        validarValor: function() {

            let result = true;
            let valor = numeral(this.comprovante.valor);
            let valorAntigo = this.valorantigo ? parseFloat(this.valorantigo) : 0;
            let valorcomprovado = parseFloat(this.valorcomprovado);
            let valorComprovadoAtual = (valorcomprovado - valorAntigo) + (valor.value());
            let valoraprovado = numeral(parseFloat(this.valoraprovado));
            let valorPermitido = parseFloat(this.valoraprovado) - parseFloat(this.valorcomprovado);

            if(this.comprovante.valor == '') {
                this.$refs.valor.focus();
                this.c.valor.css = 'active invalid red-text';

                return false;
            }

            if(valorComprovadoAtual > valoraprovado.value()) {
                this.$refs.valor.focus();
                this.c.valor.css = 'active invalid red-text';
                alert(
                    'Valor acima do permitido:' + this.comprovante.valor 
                    + ', maximo a ser acrescentado e: ' + valorPermitido
                );

                return false;
            }
            return result;
        },
        file: function() {
            this.comprovante.arquivo = this.$refs.arquivo.files[0];
            this.comprovante.foiAtualizado = true;
            this.c.arquivo.css = '';
        },
        pesquisarFornecedor: function(){
           var vue = this;
           var url = '/prestacao-contas/gerenciar/fornecedor' ;

           if (
               (this.comprovante.fornecedor.tipoPessoa == 1
                && this.comprovante.fornecedor.CNPJCPF.length == 11)
               || ( this.comprovante.fornecedor.tipoPessoa == 2
                    && this.comprovante.fornecedor.CNPJCPF.length == 14)
           ) {
               $3.ajax({
                    url: url,
                    method: 'POST',
                    data: {cnpjcpf: this.comprovante.fornecedor.CNPJCPF},
                    dataType: "json",
               }).done(function(data){
                    if (data.retorno){
                        vue.comprovante.fornecedor.nome= data.nome;
                        vue.comprovante.fornecedor.idAgente = data.idAgente;
                        vue.c.fornecedor.CNPJCPF.css = {};
                    }
               });
           }
        },
        paises: function(){
           var vue = this;
           var url = '/prestacao-contas/gerenciar/pais' ;

           $3.ajax({
                url: url,
                dataType: "json",
           }).done(function(data){
                if (data){
                    vue.pais = data;
                }
           });
        },
        inputCNPJCPF: function(e) {
            if (e.length < 15) {
                if (e.length == 11 || e.length == 14) {
                   this.comprovante.fornecedor.CNPJCPF = e;
                   this.comprovante.fornecedor.cnpjcpfMask = this.cnpjcpfMask();
                } else {
                   this.comprovante.fornecedor.CNPJCPF = '';
                }
            }
        },
        cnpjcpfMask: function() {
            if ( this.comprovante.fornecedor.tipoPessoa == 1
                && this.comprovante.fornecedor.CNPJCPF.length == 11) {
                return this.comprovante.fornecedor.CNPJCPF.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/,"$1.$2.$3-$4")
            } else if(this.comprovante.fornecedor.tipoPessoa == 2
                && this.comprovante.fornecedor.CNPJCPF.length == 14) {
                return this.comprovante.fornecedor.CNPJCPF.replace(/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/,"$1.$2.$3/$4-$5")
            }
        },
        forncedorNacional: function(e) {
            this.comprovante.fornecedor.nacionalidade = 31;
            this.comprovante.fornecedor.eInternacional = false;
        },
        fornecedorInternacional: function(e) {
            this.paises();
            this.comprovante.fornecedor.nacionalidade = 0;
            this.comprovante.fornecedor.eInternacional = true;
        },
        resetTipoPessoa: function(e) {
            this.comprovante.fornecedor.nome = '';
            this.comprovante.fornecedor.CNPJCPF = '';
            this.comprovante.fornecedor.cnpjcpfMask = '';
        },
        inputNome(e) {
            if (e.length > 0) {
               this.c.fornecedor.nome.css = {};
            }
        },
        inputNumero: function(e) {
            if (e.length > 0) {
               this.c.numero.css = {};
            }
        },
        inputDataEmissao: function(e) {
            if (e.length > 0) {
               this.c.dataEmissao.css = {};
            }
        },
        inputDataPagamento: function(e) {
            if (e.length > 0) {
               this.c.dataPagamento.css = {};
            }
        },
        inputNumeroDocumento(e) {
            if (e.length > 0) {
               this.c.numeroDocumento.css = {};
            }
        },
        inputValor(e) {
            if (e > 0) {
               this.c.valor.css = {};
            }
        },
        cancelar: function () {
            $3('#modal1').modal('close');
            this.$root.$emit('atualizado-comprovante-internacional');
        },
    }
});

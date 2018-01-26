Vue.component('salic-proposta-planilha-orcamentaria', {
    template:
        `<div class="local-realizacao-deslocamento">
            <div class="card">
                <div class="card-content">
                    <h5>Planilha Or&ccedil;ament&aacute;ria</h5>

                    <table v-if="proposta" class="bordered responsive-table">
                        <thead>
                        <tr>
                            <th>Etapa</th>
                            <th>Item</th>
                            <th>Valor unitario</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="item in proposta">
                            <td>{{ item.DescricaoEtapa }}</td>
                            <td>{{ item.DescricaoItem }}</td>
                            <td>{{ item.ValorUnitario }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div v-else>Nenhuma localiza&ccedil;&atilde;o</div>
                </div>
            </div>
   
          
        </div>
    `,
    data: function () {
        return {
            proposta: []
        }
    },
    props: ['idpreprojeto', 'planilha'],
    mounted: function () {
        if (typeof this.idpreprojeto != 'undefined') {
            this.fetch(this.idpreprojeto);
        }
        // if (typeof this.planilha != 'undefined') {
        //     this.proposta = this.planilha;
        //     console.log(this.planilha);
        // }
    },
    watch: {
        idpreprojeto: function (value) {
            this.fetch(value);
        },
        planilha: function (value) {
            this.proposta = value.tbplanilhaproposta;
        }

    },
    methods: {
        fetch: function (id) {
            if (id) {
                let vue = this;
                $3.ajax({
                    url: '/proposta/visualizar/obter-local-realizacao-deslocamento/idPreProjeto/' + id
                }).done(function (response) {
                    vue.proposta = response.data;
                });
            }
        },
        formatar_data: function (date) {

            date = moment(date).format('DD/MM/YYYY');

            return date;
        }
    }
});
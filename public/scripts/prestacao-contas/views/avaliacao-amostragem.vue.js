Vue.component('avaliacao-amostragem', {
    props: [
        'idpronac',
        'avaliacao',
    ],
    template: `
        <div>
            <sl-planilha-produtos :produtos="produtos" :idpronac="idpronac"></sl-planilha-produtos>
        </div>
    `,
    mounted: function () {
        let vue = this;
        $3.ajax({
            url: this.buildUrl()
        }).done(function( data ) {
            vue.$data.produtos = data;
        });
    },
    data: function () {
        return {
            produtos: []
        };
    },
    methods: {
        iniciarCollapsible: function () {
            $3('.collapsible').each(function() {
                $3(this).collapsible();
            });
        },
        buildUrl: function() {
            return '/prestacao-contas/prestacao-contas/comprovantes-amostragem/idPronac/'
            + this.idpronac
            + '/tipoAvaliacao/'
            + this.avaliacao;
        },
    },
})

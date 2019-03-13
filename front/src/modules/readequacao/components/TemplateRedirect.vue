<template>
    <div></div>
</template>
<script>
export default {
    name: 'TemplateRedirect',
    props: {
        campo: { type: Object, default: () => {} },
        dadosReadequacao: { type: Object, default: () => {} },
        redirecionar: { type: Boolean, default: () => false },
    },
    data() {
        return {
            tiposReadequacoesRedirect: {
                local_realizacao: '/readequacao/local-realizacao/index/?idPronac=${idPronac}',
                planilha_orcamentaria: '/readequacao/readequacoes/planilha-orcamentaria/?idPronac=${idPronac}',
                saldo_aplicacao: '#/readequacao/saldo-aplicacao/{idPronac}',
                plano_distribuicao: '/readequacao/plano-distribuicao/index/?idPronac=${idPronac}',
                remanejamento_50: '/readequacao/remanejamento-menor/index/?idPronac=${idPronac}',
            },
            urlRedirect: '',
        };
    },
    watch: {
        campo() {
            const chave = `key_${this.dadosReadequacao.idTipoReadequacao}`;
            if (Object.prototype.hasOwnProperty.call(this.campo, chave)) {
                if (typeof this.campo[chave].tpCampo !== 'undefined') {
                    const tpCampo = this.campo[chave].tpCampo;
                    this.urlRedirect = this.tiposReadequacoesRedirect[tpCampo];
                }
            }
        },
        redirecionar() {
            if (this.redirecionar) {
                const idPronac = this.dadosReadequacao.idPronac;
                const routePath = eval('`' + this.urlRedirect + '`');
                if (routePath.match(/#/)) {
                    this.$router.push({ path: routePath });
                } else {
                    window.location.href = routePath;
                }
            }
        },
    },
};
</script>

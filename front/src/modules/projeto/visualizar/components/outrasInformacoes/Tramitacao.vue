<template>
    <div id="conteudo">
        <div v-if="dadosProjeto">
            <IdentificacaoProjeto :pronac="dadosProjeto.Pronac"
                                  :nomeProjeto="dadosProjeto.NomeProjeto">
            </IdentificacaoProjeto>
            <fieldset style="margin: 0px;">
                <legend>&Uacute;ltima Tramita&ccedil;&atilde;o</legend>
                <UltimaTramitacao :idPronac="dadosProjeto.idPronac"></UltimaTramitacao>
            </fieldset>
        </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import IdentificacaoProjeto from './IdentificacaoProjeto';
import UltimaTramitacao from './components/UltimaTramitacao';

export default {
    name: 'Tramitacao',
    props: ['idPronac'],
    components: {
        IdentificacaoProjeto,
        UltimaTramitacao,
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
        }),
    },
};
</script>


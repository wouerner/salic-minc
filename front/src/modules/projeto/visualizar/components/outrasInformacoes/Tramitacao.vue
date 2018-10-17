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

            <fieldset style="margin: 0px;">
                <legend>Tramita&ccedil;&atilde;o do Projeto</legend>
                <TramitacaoProjeto
                        :idPronac="dadosProjeto.idPronac">
                </TramitacaoProjeto>
            </fieldset>
        </div>
    </div>
</template>
<script>
import { mapGetters } from 'vuex';
import IdentificacaoProjeto from './IdentificacaoProjeto';
import UltimaTramitacao from './components/UltimaTramitacao';
import TramitacaoProjeto from './components/TramitacaoProjeto';

export default {
    name: 'Tramitacao',
    props: ['idPronac'],
    components: {
        IdentificacaoProjeto,
        UltimaTramitacao,
        TramitacaoProjeto,
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
        }),
    },
};
</script>


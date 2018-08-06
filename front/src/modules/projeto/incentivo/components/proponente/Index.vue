<template>
    <div id="conteudo">
        <div id="proponente">
            <fieldset>
                <Identificacao></Identificacao>
            </fieldset>
            <fieldset>
                <Endereco></Endereco>
            </fieldset>
            <fieldset>
                <Telefone></Telefone>
            </fieldset>
            <fieldset>
                <Email></Email>
            </fieldset>
            <fieldset>
                <Natureza></Natureza>
            </fieldset>
            <fieldset>
                <Dirigente></Dirigente>
            </fieldset>
            <fieldset>
                <Procurador></Procurador>
            </fieldset>
        </div>    
    </div>
</template>

<script>
import Identificacao from './Identificacao';
import Endereco from './Endereco';
import Telefone from './Telefone';
import Email from './Email';
import Natureza from './Natureza';
import Dirigente from './Dirigente';
import Procurador from './Procurador';

export default {
  components: {
    Identificacao,
    Endereco,
    Telefone,
    Email,
    Natureza,
    Dirigente,
    Procurador,
  }
};
</script>
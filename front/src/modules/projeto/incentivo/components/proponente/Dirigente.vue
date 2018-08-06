<template>
    <div id="conteudo">
        <legend>Dirigente</legend>
        <table class="tabela" v-if="Object.keys(dirigentes)>'0'">
                <tr class="destacar">
                    <td width="20%" align="center"><b>CPF</b></td>
                    <td align="center"><b>Nome</b></td>
                </tr>
                <tr v-for="dirigente in dirigentes" v-bind:key="dirigente.idAgente">
                    <td align="center" v-if="dirigente.CNPJCPFDirigente">{{dirigente.CNPJCPFDirigente}}</td> <!--Se não tiver, mostrar 'Dado não cadastrado'  : aplicaMascara($tbdirigentes->CNPJCPFDirigente, "999.999.999-99");-->
                    <td align="center" v-else>Dados não informados!</td> <!--Se não tiver, mostrar 'Dado não cadastrado'  : aplicaMascara($tbdirigentes->CNPJCPFDirigente, "999.999.999-99");-->
                    <td align="left">{{dirigente.NomeDirigente}}</td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                        <table class='tabela'>
                            <tr class="destacar">
                                <td class="centro" colspan="4">Mandatos</td>
                            </tr>
                            <tr v-if="Object.keys(mandatos)>'0'" v-for="mandato in mandatos" v-bind:key="mandato.idMandato">
                                <td>
                                    <b>Tipo de documento</b><br>
                                    {{mandato.Descricao}}
                                </td>
                                <td>
                                    <b>Nº do documento</b><br>
                                    {{mandato.dsNumeroDocumento}}
                                </td>
                                <td>
                                    <b>Per&iacute;odo de vig&ecirc;ncia</b><br>
                                    {{mandato.dtInicioMandato}} á {{mandato.dtFimMandato}}
                                </td>
                                <td>
                                    <b>Arquivo</b><br>
                                    <a v-bind:href="mandato.idArquivo">{{mandato.nmArquivo}}</a>
                                </td>
                            </tr>
                            <tr v-else>
                                <td class="centro" colspan="4"><em>N&atilde;o existem mandatos cadastrados!</em></td>
                            </tr>
                        </table>
                    </td>
                </tr>
        </table>
        <table class="tabela" v-else>
            <tr>
                <td colspan="2" align="center"><em>N&atilde;o existem Dirigentes cadastrados!</em></td>
            </tr>
        </table>
    </div>
</template>
<script>
    export default{
        data(){
            return{
                dirigentes:[]
            }
        }
    }
</script>
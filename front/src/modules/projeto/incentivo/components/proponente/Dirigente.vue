<template>
    <div class="conteudo">
        <legend>Dirigente</legend>
        <table class="tabela" v-if="Object.keys(dirigentes)>'0'">
            <tr class="destacar">
                <td width="20%" align="center"><b>Nome/CPF</b></td>
                <td align="center"><b>Mandatos</b></td>
            </tr>
            <tr v-for="dirigente in dirigentes" v-bind:key="dirigente.idAgente" 
                v-if="dirigente.CNPJCPFDirigente">
                <td align="center"><b>{{dirigente.NomeDirigente}}</b> <br>{{dirigente.CNPJCPFDirigente}}</td>
                <td align="left">
                    <table class='tabela' v-if="Object.keys(dirigente.mandatos).length>0">
                        <tr v-for="mandato in dirigente.mandatos" v-bind:key="mandato.idMandato">
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
                                {{mandato.dtInicioMandato | formatarData}} à {{mandato.dtFimMandato | formatarData}}
                            </td>
                            <td>
                                <b>Arquivo</b><br>
                                <a v-bind:href="mandato.idArquivo">{{mandato.nmArquivo}}</a>
                            </td>
                        </tr>
                    </table>
                    <div v-else>
                        <em>N&atilde;o existem mandatos cadastrados!</em>
                    </div>
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
import moment from 'moment';
    
    export default{
        data(){
            return{
                dirigentes:[
                    {idAgente:'152', CNPJCPFDirigente:'15648975602', NomeDirigente:'Fulano de Tal',
                    mandatos:[
                        {idMandato:'55', Descricao:'alguma coisa', dsNumeroDocumento:'156489',
                         dtInicioMandato:'2018-08-01', dtFimMandato:'2018-08-10', idArquivo:'algum link',
                         nmArquivo:'Baixar Mandato dnv'},
                    ]},
                    {idAgente:'007', CNPJCPFDirigente:'12345678902', NomeDirigente:'James Bond',
                    mandatos:[
                        {idMandato:'45', Descricao:'blablabla', dsNumeroDocumento:'789546',
                         dtInicioMandato:'2018-08-03', dtFimMandato:'', idArquivo:'qualquer link',
                         nmArquivo:'Baixar Mandato'},
                    ]}

                ],
            }
        },
        filters: {
            formatarData(date) {
                if (date.length === 0) {
                    return ' --';
                }
                return moment(date).format('DD/MM/YYYY');
            },
        },
    }
</script>
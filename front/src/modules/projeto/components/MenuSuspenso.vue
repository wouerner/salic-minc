<template>
    <div>
        <div class="fixed-action-btn vertical">
            <a class="btn-floating btn-large red">
                <i class="large material-icons">add</i>
            </a>
            <ul>
                <li>
                    <a id="ir-para-o-topo" class="btn-floating yellow darken-1 tooltipped"
                       data-tooltip="Ir para o topo">
                        <i class="material-icons">arrow_upward</i>
                    </a>
                </li>
                <li v-if="idPronac">
                    <a class="btn-floating blue tooltipped"
                       href='javascript:void(0)'
                       v-on:click="imprimirProjeto(idPronac)"
                       data-tooltip="Imprimir Projeto"
                    ><i class="material-icons">print</i></a>
                </li>
            </ul>
        </div>
        <div id="boxImprimirProjeto" style="display: none;"></div>
    </div>
</template>
<script>

    export default {
        data() {
            return {
                idPronac: this.$route.params.idPronac
            }
        },
        created() {
   
             this.irParaOTopo();
        },
        methods: {
            imprimirProjeto(idPronac) {
                let self = this;

                $('#boxImprimirProjeto').html("<br><br><center>Carregando dados...</center>");

                $.ajax({
                    url: '/default/consultardadosprojeto/form-imprimir-projeto?idPronac=' + idPronac,
                    data:
                        {
                            idPronac: idPronac
                        },
                    success: function (data) {
                        $('#boxImprimirProjeto').html(data);
                    },
                    type: 'post'

                });

                $("#boxImprimirProjeto").dialog({
                    title: 'Imprimir Projeto',
                    resizable: true,
                    width: 750,
                    height: 460,
                    modal: true,
                    autoOpen: false,
                    buttons: {
                        'Fechar': function () {
                            $(this).dialog('close');
                        },
                        'OK': function () {
                            self.submeteForm();
                            //$('#frmOpcoesImpressao').submit();
                        }
                    }
                });
                $("#boxImprimirProjeto").dialog('open');
            },
            submeteForm() {
                var n = $("input:checked").length;
                if (n > 0) {
                    $('#msgErroImpressao').html("");
                    $('#frmOpcoesImpressao').submit();
                } else {
                    $('#msgErroImpressao').html("<center><font color='red'>É obrigatório selecionar ao menos uma informação para impressão.</font></center>");
                }
            },
            irParaOTopo() {
                if ($3('#ir-para-o-topo').length) {
                    var scrollTrigger = 100, // px
                        backToTop = function () {
                            var scrollTop = $3(window).scrollTop();
                            if (scrollTop > scrollTrigger) {
                                $3('#ir-para-o-topo').parent().show();
                            } else {
                                $3('#ir-para-o-topo').parent().hide();
                            }
                        };
                    backToTop();

                    $3(window).on('scroll', function () {
                        backToTop();
                    });

                    $3('#ir-para-o-topo').on('click', function (e) {
                        e.preventDefault();
                        $3('html,body').animate({
                            scrollTop: 0
                        }, 700);
                    });
                }
            }
        }
    };
</script>
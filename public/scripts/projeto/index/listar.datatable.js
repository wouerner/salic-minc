(function ($) {
    $(document).ready(function () {

        var table =  $('#lista-de-projetos').DataTable(
            {
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.12/i18n/Portuguese-Brasil.json"
                }
                , "lengthChange": true
                , "ajax": {
                url: "/projeto/index/listar-projetos-ajax",
                data: {
                    "id": function (d) {
                        return $('#idProponente').val();
                    },
                    "mecanismo": function (d) {
                        return $('#mecanismo').val();
                    }
                },
                type: "POST"
            },
                "processing": true,
                "serverSide": true,
                "bFilter": false,
                "aoColumnDefs": [
                    {'bSortable': false, 'aTargets': [2, 3,4]}
                ],
                "order": [[ 0, 'desc' ], [ 1, 'asc' ]],
                "columns": [
                    {
                        data: null,
                        "name": "pronac",
                        render: function (data, type, row) {
                            return '<a class="btn waves-effect waves-darrk white black-text small" href="/default/cosultardadosprojeto/index/idPronac/' + data.idPronacHash+ '">'
                            + data.pronac + '</a>'
                        }
                    },
                    {
                        data: null,
                        "name": "nomeprojeto",
                        render: function (data, type, row) {
                            return '<a class="" href="/default/cosultardadosprojeto/index/idPronac/' + data.idPronacHash+ '">'
                            + data.nomeprojeto + '</a>'
                        }

                    },
                    {
                        "name": "situacao",
                        "data": "situacao"

                    },
                    {
                        "name": "periodo",
                        "data": "periodo"

                    },
                    {
                        "name": "mecanismo",
                        "data": "mecanismo"

                    },
                    {
                        data: null,
                        "name": "actions",
                        render: function (data, type, row) {
                            return '<div style="position: relative; height: 60px;">'
                                + '<div class="fixed-action-btn horizontal" style="position: absolute; top: 0px; right: 0; z-index: 996; padding: 15px 0 0 15px;">'
                                + '<a class="btn btn-primary small">'
                                + '<i class="material-icons">more_vert</i></a>'
                                + '<ul>'
                                + '<li>'
                                + '<a class="btn-floating red" title="Ir para solicita&ccedil;&otilde;es" href="/solicitacao/mensagem/index/idPronac/' + data.idPronac + '">'
                                + '<i class="material-icons">message</i>'
                                + '</a></li>'
                                + '</ul>'
                                + '</div></div>'
                        }
                    }
                ]
            }
        );

        $3('.tooltipped').tooltip({delay: 50});

        $("#idProponente").change(function () {
            table.ajax.reload();
        });

    });
}($.noConflict(true)));
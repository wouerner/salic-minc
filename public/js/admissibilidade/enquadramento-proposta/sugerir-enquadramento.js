function carregarSegmento() {
    $3('#segmentoCultural').html('<option value=""> - Carregando - </option>');
    $3.ajax({
        type: 'POST',
        url: $("#action_segmento").val(),
        data: {
            id: $3('#areaCultural').val()
        },
        success: function (dados) {
            $3('#segmentoCultural').find('option').remove();
            $3('#segmentoCultural').append(dados);
        }
    });
}

function carregarEnquadramento(object) {
    $3("#bloco-Artigo").show();
    $3('#enquadramentoText').html('Artigo 26');
    var enquadramentoProjeto = $3(object).children('option:selected').data('tp_enquadramento');

    if (enquadramentoProjeto == '2') {
        $3('#enquadramentoText').html('Artigo 18');
    }
    $3('#enquadramento_preprojeto').val(enquadramentoProjeto);
}

jQuery(function ($) {

    var limiteMaximo = 8000;

    var editorRico = $("#observacao").editorRico({
        altura: 200,
        isLimitarCarateres: true,
        maxchar: limiteMaximo
    });

    $3('#areaCultural').change(function () {
        $3("#bloco-Artigo").hide();
        carregarSegmento();
    });

    $3('#segmentoCultural').change(function () {
        carregarEnquadramento(this);
    });


    $("#formEnquadramentoProjeto").validate({
        rules: {
            observacao: {
                validarPreenchimento: true,
                validarPreenchimentoMaximo: true
            }
        },
        messages: {
            observacao: {
                validarPreenchimento: "Dado obrigat&oacute;rio n&atilde;o informado",
                validarPreenchimentoMaximo: "limite excedido"
            }
        },

        submitHandler: function (form) {
            $("#container-progress").show();
            form.submit();
        },
        invalidHandler: function (event, validator) {
            Materialize.toast(validator.submitted.observacao, 4000);
        }
    });

    $.validator.addMethod("validarPreenchimento", function (value, element) {
        if (editorRico.contarCaracteres() > 0) {
            return true;
        }
    });
    $.validator.addMethod("validarPreenchimentoMaximo", function (value, element) {
        if (editorRico.contarCaracteres() <= limiteMaximo) {
            return true;
        }
    });
});
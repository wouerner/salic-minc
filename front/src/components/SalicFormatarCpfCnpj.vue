<template>
    <div v-if="cpfCnpjFormatado && cpfCnpjFormatado.length > 0" v-html="cpfCnpjFormatado"></div>
    <div v-else>N&atilde;o informado(a)</div>
</template>

<script>
    export default {
        name: 'SalicFormatarCpfCnpj',
        props: ['cpf'],
        computed: {
            cpfCnpjFormatado: function () {
                if (typeof this.cpf != 'undefined') {
                    return this.formatarCpfOuCnpj(this.cpf);
                }
            }
        },
        methods: {
            formatarCpfOuCnpj: function (cpfOrCnpj) {
                if (cpfOrCnpj.length == 11) {
                    return this.formatarCpf(cpfOrCnpj);
                }
                return this.formatarCnpj(cpfOrCnpj);
            },
            formatarCpf: function (v) // formato: 999.999.999-99
            {
                v = v.replace(/\D/g, "");
                v = v.replace(/(\d{3})(\d)/, "$1.$2");
                v = v.replace(/(\d{3})(\d)/, "$1.$2");
                v = v.replace(/(\d{3})(\d)/, "$1-$2");
                return v;
            },
            formatarCnpj: function (v) // formato: 99.999.999/9999-99
            {
                v = v.replace(/\D/g, "");
                v = v.replace(/(\d{2})(\d)/, "$1.$2");
                v = v.replace(/(\d{3})(\d)/, "$1.$2");
                v = v.replace(/(\d{3})(\d)/, "$1/$2");
                v = v.replace(/(\d{4})(\d)/, "$1-$2");
                return v;
            }
        }
    };
</script>
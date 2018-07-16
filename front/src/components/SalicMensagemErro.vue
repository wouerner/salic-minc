<template>
    <div class="card center-align" style="margin: 20px auto; width:80%">
        <div class="card-content">
            <div class="row">
                <div class="col s2 right-align"><i class="medium red-text material-icons">not_interested</i></div>
                <div class="col s10 left-align">
                    <br>
                    <b>
                        <CharsetEncode :texto="texto"></CharsetEncode>
                    </b>
                    <a v-if="urlRetorno" href="urlRetorno">
                        <CharsetEncode :texto="msgUrlRetorno"></CharsetEncode>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import CharsetEncode from '@/components/CharsetEncode';

    export default {
        name: 'SalicMensagemErro',
        components: {
            CharsetEncode
        },
        props: ['texto', 'urlRetorno', 'msgUrlRetorno'],
    };
</script>

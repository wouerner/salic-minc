<template>
    <div>
        <v-btn round
               dark
               target="_blank"
               @click="printTable"
        >
            Imprimir
            <v-icon right dark>local_printshop</v-icon>
        </v-btn>

        <button class="btn btn-primary pull-left" @click="printTable">Print</button>
        <div id="data-table">
            <datatable v-bind="$props" />
        </div>
    </div>
</template>
<script>
    import Vue from 'vue'
    import Datatable from 'vue2-datatable-component'
    import _ from 'lodash'
    import PH from 'print-html-element'

    Vue.use(Datatable);

    export default {
        name: 'PrintableDataTable',
        data () {
            return {}
        },
        props: {
            columns: { type: Array, required: true },
            data: { type: Array, required: true }, // rows
            total: { type: Number, required: true },
            query: { type: Object, required: true },
            selection: Array, // container for multi-select
            summary: Object, // an extra summary row
            xprops: Object, // extra custom props carrier passed to dynamic components
            pageSizeOptions: { type: Array, default: () => [10, 20, 40, 80, 100] },
            tblClass: [String, Object, Array], // classes for <table>
            tblStyle: [String, Object, Array], // inline styles for <table>
            fixHeaderAndSetBodyMaxHeight: Number, // a fancy prop which combines two props into one
            supportNested: [Boolean, String], // support nested components feature (String is only for 'accordion')
            supportBackup: Boolean // support backup for `HeaderSettings`
        },
        methods: {
            printTable: function () {
                PH.printElement(document.getElementById('data-table'))
            }
        }
    }
</script>

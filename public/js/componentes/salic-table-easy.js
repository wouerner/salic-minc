Vue.component(
    'salic-table-easy',
    {
        template:`
            <table class="">
                <thead v-show="thead">
                    <th v-html="cab" v-for="cab in dados.cols"></th>
                </thead>
                <tbody>
                    <tr v-for="dado in dados.lines">
                        <td v-html="d" v-for="d in dado"></td>
                    </tr>
                </tbody>
                <tfoot v-if="tfoot">
                    <tr>
                        <td v-html="foot" v-for="foot in dados.foot"></td>
                    </tr>
                </tfoot>
            </table>
        `,
        props: {dados : null, thead: { default: true}, tfoot: { default: false}
    }
});

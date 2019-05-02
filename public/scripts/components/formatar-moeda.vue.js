Vue.component('formatar-moeda', {
    template: `<input
        type="text"
        class="validate right-align"
        v-bind:disabled="false"
        v-bind:value="value"
        ref="input"
        v-on:input="updateMoney($event.target.value)"
        v-on:blur="formatValue"
    />`,
    props: {
        value: {
            default: 0
        },
        disabled: {
            type: Boolean,
            default: false
        }
    },
    data: function () {
        return {
            val: 1
        }
    },
    watch: {
        disabled: function () {
            this.$refs.input.disabled = this.disabled;
            if (this.disabled) {
                this.val = 0;
            }
        }
    },    
    mounted: function () {
        this.formatValue();
        this.$refs.input.disabled = this.disabled;
    },
    methods: {
        formatValue: function () {
            let num = Number(this.$refs.input.value);
            if (_.isNaN(num)
                || num === 0) {
                this.$refs.input.value = 0;
                return;
            }
            num = num.toLocaleString(
                'pt-br',
                {
                    style: 'currency',
                    currency: 'brl',
                    currencyDisplay: 'code',
                },
            );
            num = num.toLowerCase().split('brl')[1];
            this.$refs.input.value = num;
        },
        updateMoney: function (value) {
            this.val = value;
            this.$emit('ev', this.val)
        }
    },
});

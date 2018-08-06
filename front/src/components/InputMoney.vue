<template>
    <input
      type="text"
      class="validate right-align"
      ref="input"
      v-bind:disabled="false"
      v-bind:value="value"
      v-on:input="updateMoney($event.target.value)"
      v-on:blur="formatValue"
      />
</template>
<script>
import numeral from 'numeral';

export default {
    name: 'InputMoney',
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
    mounted: function () {
        this.formatValue();
        this.$refs.input.disabled = this.disabled;
    },
    methods: {
        formatValue: function () {
            this.$refs.input.value = numeral(this.$refs.input.value).format();
        },
        updateMoney: function (value) {
            this.val = value;
            this.$emit('ev', this.val)
        }
    },
    watch: {
        disabled: function () {
            this.$refs.input.disabled = this.disabled;
            if (this.disabled) {
                this.val = 0;
            }
        }
    }
}
</script>

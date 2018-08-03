<template>
    <div id="modal1" class="modal">
        <div class="modal-content">
            <div class="">
                <h2 class=""><slot name="header"></slot></h2>
            </div>
            <div class="">
                <slot name="body"></slot>
            </div>
        </div>
        <div class="modal-footer">
            <slot name="footer">
                <button class="btn btn-danger" @click="fecharModal();$event.preventDefault()">
                    Cancelar
                </button>
            </slot>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        $3('.modal').modal();
        $3('#modal1').modal('open');
    },
    methods: {
        fecharModal() {
            $3('#modal1').modal('close');
            this.$emit('close');
        }
    }
};
</script>

<style>
</style>

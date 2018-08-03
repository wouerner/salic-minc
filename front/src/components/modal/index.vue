<template>
    <div id="modal1" class="modal modal-fixed-footer">
        <div class="modal-content">
            <div class="modal-header">
                <h2><slot name="header"></slot></h2>
            </div>
            <div class="modal-body">
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
        // eslint-disable-next-line
        $3('.modal').modal();
        // eslint-disable-next-line
        $3('#modal1').modal('open');
    },
    methods: {
        fecharModal() {
            // eslint-disable-next-line
            $3('#modal1').modal('close');
            this.$emit('close');
        },
    },
};
</script>

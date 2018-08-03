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

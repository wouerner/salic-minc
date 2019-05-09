<template>
    <div
        class="pa-2"
    >
        <v-btn
            flat
            class="blue lighten-2 mr-2"
            color="white"
            @click="openFileDialog"
        >
            {{ textoBotao }}
            <v-icon
                small
                color="white"
            >note_add</v-icon>
        </v-btn>
        <input
            id="file-upload"
            ref="file"
            type="file"
            style="display:none;"
            @change="handleFileUpload()"
        >
        <v-btn
            v-if="possuiDocumento"
            flat
            class="green lighten-2"
            color="white"
            @click="abrirArquivo(idDocumento)"
        >
            VISUALIZAR&nbsp;
            <v-icon small>visibility</v-icon>
        </v-btn>
        <v-btn
            v-if="possuiDocumento"
            flat
            class="red lighten-2"
            color="white"
            @click="removerArquivo()"
        >
            EXCLUIR
            <v-icon small>
                delete
            </v-icon>
        </v-btn>
    </div>
</template>

<script>
import _ from 'lodash';
import abrirArquivo from '../mixins/abrirArquivo';
import Carregando from '@/components/CarregandoVuetify';

export default {
    name: 'UploadFile',
    components: {
        Carregando,
    },
    mixins: [abrirArquivo],
    props: {
        formatosAceitos: {
            type: Array,
            default: () => ['application/pdf'],
        },
        idDocumento: {
            type: [
                Number,
                String,
            ],
            default: 0,
        },
    },
    data() {
        return {
            file: '',
        };
    },
    computed: {
        textoBotao() {
            return (this.possuiDocumento) ? 'ALTERAR' : 'ADICIONAR';
        },
        possuiDocumento() {
            if (_.isNull(this.idDocumento)
                || this.idDocumento === 0) {
                return false;
            }
            return true;
        },
    },
    methods: {
        openFileDialog() {
            document.getElementById('file-upload').click();
        },
        checkFormat(file) {
            if (!this.formatosAceitos.find(i => i === file.type)) {
                const payload = {
                    mensagem: 'Tipo não aceito',
                    formatoEnviado: file.type,
                    formatosAceitos: this.formatosAceitos,
                };
                this.$emit('arquivo-tipo-invalido', payload);
                return false;
            }
            return true;
        },
        handleFileUpload() {
            const file = this.$refs.file.files[0];
            if (this.checkFormat(file)) {
                this.file = file;
                if (this.$refs.file.files[0]) {
                    const payload = this.$refs.file.files[0];
                    this.$emit('arquivo-anexado', payload);
                } else {
                    this.$emit('arquivo-removido');
                }
            }
        },
        removerArquivo() {
            this.$emit('arquivo-removido');
        },
    },
};
</script>

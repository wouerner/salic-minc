<template>    
    <div id="app">
        <vue-editor
            :editorToolbar="customToolbar"
            :placeholder="'Texto do Parecer *'"
        >
        </vue-editor>
    </div>
</template>

<script>
    import { VueEditor } from "vue2-editor";
    
    export default {
        components: {
            VueEditor
        },
        data() {
            return {
                customToolbar:  [
                    [{ 'font': [] }],
                    [{ 'header': [false, 1, 2, 3, 4, 5, 6, ] }],
                    [{ 'size': ['small', false, 'large', 'huge'] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{'align': ''}, {'align': 'center'}, {'align': 'right'}, {'align': 'justify'}],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'indent': '-1'}, { 'indent': '+1' }],
                    [{ 'color': [] }],
                ]
            }
        },

    };

</script>

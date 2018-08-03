<template>
  <div>
    <!-- Modal Trigger -->
    <a class="waves-effect waves-light btn modal-trigger" href="#modal1">Modal</a>

    <!-- Modal Structure -->
    <div id="modal1" class="modal modal-fixed-footer">
        <div class="modal-content">
        <h4>Modal Header</h4>
        <p>A bunch of text</p>
        </div>
        <div class="modal-footer">
        <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
        </div>
    </div>
  </div>
</template>

<script>
export default {
    mounted() {
        $3(document).ready(() => {
        $3('.modal').modal();
    })},
};
</script>

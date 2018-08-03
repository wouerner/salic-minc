<template>
  <div class="custom-modal">
    <div class="custom-modal__dialog">
      <div class="custom-modal__content">
        <header class="custom-modal__header">
          <h2 class="custom-modal__title"><slot name="header"></slot></h2>
          <button class="custom-modal__close button" @click="$emit('close');$event.preventDefault()">
            <i class="glyphicon glyphicon-remove">AAA</i>
          </button>
        </header>
        <div class="custom-modal__body">
          <slot name="body"></slot>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
};
</script>

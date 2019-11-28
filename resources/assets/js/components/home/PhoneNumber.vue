<template lang="pug">
    a(:href="phoneHref")
      .phone
        .phone__icon
        .phone__number {{phoneText}}
</template>
<script>
export default {
  name: 'PhoneNumber',
  // eslint-disable-next-line vue/require-prop-types
  props: ['phoneNumber'],
  computed: {
    phoneHref() {
      return 'tel: ' + this.phoneNumber.replace(/[()\s-]/g, '')
    },
    phoneText() {
      const str = this.phoneNumber
      return str.substr(0,2)+'('+str.substr(2,3)+') '+str.substr(5,3)+'-'+str.substr(8,2)+'-'+str.substr(10,2)
    }
  }
}
</script>
<style lang="scss">
.phone {
  display: flex;
  justify-content: flex-start;
  align-items: center;

  &__icon {
    background-image: url('../../../images/phone.svg');
    background-size: contain;
    background-repeat: no-repeat;
    width: 1em;
    height: 1em;
  }

  &__number {
  }
}
</style>

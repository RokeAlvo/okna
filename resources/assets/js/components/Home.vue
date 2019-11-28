<template lang="pug">
  .page
    Header(:city='city')
    Section1(
      class="page__section1" 
      :numberOfResidentials='numberOfResidentials' 
      :numberOfApartments='numberOfApartments'
      :fromCity='city'
      )
    Section2
    Section3
    Section4
    Section5
    Section6
    Footer
</template>

<script>
import Section1 from '@/components/home/Section1.vue'
import Header from '@/components/home/Header'
import Section2 from '@/components/home/Section2.vue'
import Section3 from '@/components/home/Section3.vue'
import Section4 from '@/components/home/Section4.vue'
import Section5 from '@/components/home/Section5.vue'
import Section6 from '@/components/home/Section6.vue'
import { createNamespacedHelpers } from "vuex";

const {
	mapState,
	mapGetters,
	mapActions,
} = createNamespacedHelpers("homePage");

export default {
  components: {
    Header,
    Section1,
    Section2,
    Section3,
    Section4,
    Section5,
    Section6
  },
  computed: {
    ...mapState({
      numberOfResidentials: state=>state.numberOfResidentials,
      numberOfApartments: state=>state.numberOfApartments,
      }),
    city() {
      return this.$store.state.siteContacts[this.$store.state.activeCity].cityNameForms[1]
    },
  },
  methods: {
    ...mapActions(['init']),
  },
  created() {
    this.init()
  }

}
</script>

<style lang="scss">
html {
  font-family: 'Montserrat', sans-serif;
  font-style: normal;
  font-weight: 600;
  font-size: 14px;
  color: $font-main-color;
  width: 100%;
  max-width: 100%;
  overflow-x: hidden;
}

*,
*:before,
*:after {
  box-sizing: border-box;
  margin: 0;
}

li {
  list-style: none;
}

a {
  color: inherit;
  text-decoration: inherit;
}
.page {
  overflow-x: hidden;
  max-width: 100vw;
}
</style>

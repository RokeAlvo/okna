<template>
  <div id="app">
    <span id="mgo-number" class="data-phone">+7 (383) 388-48-96</span>
    <!-- <compHeader></compHeader> -->
    <!-- <router-link :to="{ name: 'mapSearch'}">MapSearch</router-link> -->
    <!-- <router-link :to="{ name: 'main'}">main</router-link> -->

    <router-view></router-view>
    
  </div>
</template>

<script>
// import compHeader from "./Header_Footer/Head.vue";

export default {
  data() {
    return {
    };
  },
  components: {
    // compHeader
  },
  methods:{
    
    phoneChange() {
      setTimeout(function() {
        let phone = document.getElementById("mgo-number").innerText;
        let tel = phone.replace(/[^0-9]/gi, "");
        let inPhone = document.getElementsByClassName("change-phone");
        for (let i = 0; i < inPhone.length; i++) {
          inPhone[i].innerHTML = phone;
          inPhone[i].setAttribute("href", "tel:+" + tel);
        }
      }, 2000);
    }

  },
  created() {
    const siteContacts = window.SITE_CONTACTS;
    const cityFromUrl=window.location.pathname.toString().replace('/', '').split('/')[0]
    this.$store.dispatch("getMenuList");
    this.$store.dispatch('initialCityList', {siteContacts, cityFromUrl});
  },
  updated(){
    this.phoneChange();
  },
  mounted(){

    var dataBackend = document.getElementById('js-backend-parameters')
    if(dataBackend){
      var $mango = document.getElementById('js-backend-parameters').getAttribute('data-mango-widget-id')
      if(document.getElementById('mgo-number')){
        document.getElementById('mgo-number').classList.add(`mgo-number-${$mango}`);
      }
      
      // console.log(document.querySelector('.mgo-number-' + $mango));
      (function(w, d, u, i, o, s, p) {
        if (d.getElementById(i)) {
          return;
        }
        w["MangoObject"] = o;
        w[o] =
          w[o] ||
          function() {
            (w[o].q = w[o].q || []).push(arguments);
          };
        w[o].u = u;
        w[o].t = 1 * new Date();
        s = d.createElement("script");
        s.async = 1;
        s.id = i;
        s.src = u;
        p = d.getElementsByTagName("script")[0];
        p.parentNode.insertBefore(s, p);
      })(
        window,
        document,
        "//widgets.mango-office.ru/widgets/mango.js",
        "mango-js",
        "mgo"
      );
      mgo({
        calltracking: {
          id: $mango,
          elements: [{ selector: ".mgo-number-" + $mango }]
        }
      });
    }

    this.phoneChange();
  }
};
</script>


<style lang="scss">
// @import url('https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i');
html,
body {
  height: 100%;
  font-family: "Montserrat", sans-serif;
}
* {
  box-sizing: border-box;
}
#app {
  // height: 100%;
  display: flex;
  flex-direction: column;
}
.data-phone{
  display: none;
}
</style>



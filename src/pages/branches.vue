<template>
  <f7-page>
    <f7-navbar no-shadow no-hairline back-link="Atrás">
      <f7-nav-title>
        <img style="height: 25px" src="../assets/kingansWhite.svg">
      </f7-nav-title>
    </f7-navbar>
    <f7-block strong style="margin:0 ">
      <f7-row>
        <f7-col width="30">
          <div class="bg-primary" style="
                        width: 75px;
                        height: 75px;
                        border-radius: 100%;
                        ">
            <f7-icon style="color:white;font-size: 3em;margin: 16px;" material="place"></f7-icon>
          </div>
        </f7-col>
        <f7-col width="70">
          <h1 style="margin:0">Sucursales</h1>
          <span>KINGANS / BAKINGS</span>
        </f7-col>
      </f7-row>
    </f7-block>
    <f7-card class="elevation-2" v-for="(item, index) in items" :key="index">
      <f7-card-content>
        <img style="
                        position:absolute;
                        width: 40px; right: 8px;
                     " class="circle-image"
             :src="$store.state.application.config.api + 'images/branches/' + item.svg">
        <p>
          <span style="font-size: .9em">{{ item.city }}</span><br/>
          <span style="font-size: 1.6em">{{ item.name }}</span>
        </p>
        <p style="color: #6e6e74">
          {{ item.address }}
        </p>
        <f7-block>
          <f7-row>
            <f7-col>
              <f7-button large @click="openBrowser(item.facebook)">
                <f7-icon class="active" style="font-size: 1.5em" f7="logo_facebook"></f7-icon>
                Facebook
              </f7-button>
            </f7-col>

            <f7-col>
              <f7-button large @click="openBrowser(item.instagram)">
                <f7-icon class="active" style="font-size: 1.5em" f7="logo_instagram"></f7-icon>
                Instagram
              </f7-button>
            </f7-col>
          </f7-row>
          <f7-row>
            <f7-col>
              <f7-button large @click="scheduling = item.scheduling" popover-open=".popover-menu">
                <f7-icon class="active" style="font-size: 1.5em" material="access_time"></f7-icon>
                Horarios
              </f7-button>
            </f7-col>
            <f7-col>
              <f7-button large @click="openBrowser(item.map)">
                <f7-icon class="active" style="font-size: 1.5em" material="room"></f7-icon>
                Ubicación
              </f7-button>
            </f7-col>
          </f7-row>
          <f7-row>
            <f7-col>
              <f7-button large @click="setPhoneDialer(item.phone)" popover-open=".popover-menu-phone">
                <f7-icon class="active" style="font-size: 1.5em" material="phone"></f7-icon>
                Teléfono
              </f7-button>
            </f7-col>
            <f7-col>
              <f7-button large @click="openBrowser(item.menu_url)">
                <f7-icon class="active" style="font-size: 1.5em" material="chat"></f7-icon>
                WhatsApp
              </f7-button>
            </f7-col>
          </f7-row>
        </f7-block>
      </f7-card-content>
      <f7-card-footer>
        <f7-button large @click="openBrowser(item.menu_url)">
          <f7-icon class="active" style="font-size: 1.5em" material="chrome_reader_mode"></f7-icon>
          Pedido en Línea
        </f7-button>
      </f7-card-footer>
    </f7-card>
    <f7-popover class="popover-menu">
      <f7-block>
        <f7-block-title style="font-weight: bold; text-transform: capitalize">Horarios</f7-block-title>
        <f7-block v-html="scheduling"/>
      </f7-block>
    </f7-popover>
    <f7-popover class="popover-menu-phone">
      <f7-block>
        <f7-block-title style="font-weight: bold; text-transform: capitalize">Teléfono</f7-block-title>
        <p>{{ phone }}</p>
      </f7-block>
    </f7-popover>
  </f7-page>
</template>

<script>
export default {
  name: "branchOffices",
  data() {
    return {
      items: [],
      scheduling: '',
      phone: '',
    }
  },
  mounted: function () {
    this.getBranches();

    let vm = this;
    document.addEventListener('backbutton', function (e) {
      vm.$f7router.navigate('/')
    }, false);
  },
  methods: {
    setPhoneDialer(tel) {
      this.phone = tel;
      cordova.plugins.phonedialer.dial(tel,
          function (err) {
            console.log("Dialer Error:", err);
          },
          function (success) {
            console.log('Dialing succeeded');
          }
      );
    },
    openBrowser(url) {
      console.log(url)
      let options = "location=no,clearcache=yes,clearsessioncache=yes,zoom=yes,EnableViewPortScale=yes"
      let ref = cordova.InAppBrowser.open(url, '_system', options);
      const self = this;
      self.$f7.dialog.preloader('Cargando...');
      setTimeout(() => {
        self.$f7.dialog.close();
      }, 2000);
    },
    getBranches: function () {
      this.$f7.dialog.preloader('Cargando...');
      this.$http.post(this.$store.state.application.config.api + 'branches/get').then(response => {
        this.$f7.dialog.close();
        this.items = response.data
      }, response => {
        console.log(response, 'error on getBranches branches/get');
        this.$f7.dialog.close();
        this.$f7.dialog.alert("", 'Servidor no disponible.');
      });
    }
  },
}
</script>

<style>
.block-strong:before, .block-strong:after {
  content: none !important;
}
</style>

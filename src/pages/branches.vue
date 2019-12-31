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
                    <span style="font-size: .9em">{{item.city}}</span><br/>
                    <span style="font-size: 1.6em">{{item.name}}</span>
                </p>
                <p style="color: #6e6e74">
                    {{item.address}}
                </p>
            </f7-card-content>
            <f7-card-footer>
                <f7-link @click="openBrowser(item.facebook)">
                    <f7-icon style="font-size: 1.5em" f7="logo_facebook"></f7-icon>
                </f7-link>
                <f7-link @click="openBrowser(item.instagram)">
                    <f7-icon style="font-size: 1.5em" f7="logo_instagram"></f7-icon>
                </f7-link>
                <f7-link @click="scheduling = item.scheduling" popover-open=".popover-menu">
                    <f7-icon style="font-size: 1.5em" material="access_time"></f7-icon>
                </f7-link>
                <f7-link @click="phone = item.phone" popover-open=".popover-menu-phone">
                    <f7-icon style="font-size: 1.5em" material="phone"></f7-icon>
                </f7-link>
            </f7-card-footer>
        </f7-card>
        <f7-popover class="popover-menu">
            <f7-block>
                <f7-block-title style="font-weight: bold; text-transform: capitalize">Horarios</f7-block-title>
                <p>{{scheduling}}</p>
            </f7-block>
        </f7-popover>
        <f7-popover class="popover-menu-phone">
            <f7-block>
                <f7-block-title style="font-weight: bold; text-transform: capitalize">Teléfono</f7-block-title>
                <p>{{phone}}</p>
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
            this.getBranches()
        },
        methods: {
            openBrowser(url) {
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
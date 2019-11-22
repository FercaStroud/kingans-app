<template>
    <f7-page>
        <f7-navbar back-link="Atrás">
            <f7-nav-right>
                <f7-link @click="getCoupons">
                    <f7-icon style="" material="cached"></f7-icon>
                </f7-link>
            </f7-nav-right>
        </f7-navbar>
        <f7-block strong style="margin:0 ">
            <f7-row>
                <f7-col width="30">
                    <div style="
                        width: 75px;
                        height: 75px;
                        border-radius: 100%;
                        background-color: #f6b05d
                        ">
                        <f7-icon style="font-size: 3em;margin: 16px;" material="new_releases"></f7-icon>
                    </div>
                </f7-col>
                <f7-col width="70">
                    <h1 style="margin:0">Promociones</h1>
                    <span>CÓDIGOS</span>
                </f7-col>
            </f7-row>
        </f7-block>

        <f7-card class="elevation-2" v-for="(item, index) in items" :key="index">
            <f7-card-header>
                <span style="font-size: 1.6em">#{{item.code}}</span>
                <span style="">Código</span>
            </f7-card-header>
            <f7-card-content>
                <p style="color: #6e6e74">
                    {{item.description}}
                </p>
                <p v-if="item.branch_name" style="color: #6e6e74">
                    <strong>Sucursal:</strong> {{item.branch_name}}<br/>
                    <strong>Visitas necesarias:</strong> {{item.required_number}}
                </p>
                <p v-else style="color: #6e6e74">
                    <strong>Sucursal:</strong> ¡Todas!<br/>
                    <strong>Visitas necesarias:</strong> {{item.required_number}}
                </p>
                <p>
                    INICIA EN {{dateStringMX(item.start)}}<br/>
                    <span style="color: #ee6889; font-weight: bold">
                        TERMINA EN {{dateStringMX(item.end)}}
                    </span>
                </p>
            </f7-card-content>
            <f7-card-footer>
                <f7-link popover-open=".popover-social-links" @click="setDataToShare(item)">Compartir</f7-link>
            </f7-card-footer>
        </f7-card>
        <f7-popover class="popover-social-links">
            <f7-list>
                <f7-list-item>
                    <f7-button style="width: 100%" @click="socialShare('twitter')">
                        Twitter
                    </f7-button>
                </f7-list-item>
                <f7-list-item>
                    <f7-button style="width: 100%" @click="socialShare('facebook')">
                        Facebook
                    </f7-button>
                </f7-list-item>
                <f7-list-item>
                    <f7-button style="width: 100%" @click="socialShare('whatsapp')">
                        Whats App
                    </f7-button>
                </f7-list-item>
            </f7-list>
        </f7-popover>
    </f7-page>
</template>

<script>
    export default {
        name: "promotions",
        data() {
            return {
                items: [],
                dataToShare: null,
            }
        },
        mounted: function () {
            this.getCoupons()
        },
        methods: {
            setDataToShare(item) {
                this.dataToShare = item
            },
            socialShare(socialNetwork) {
                let url = ''
                switch (socialNetwork) {
                    case 'twitter':
                        url = 'https://twitter.com/intent/tweet?text=Descarga la app Kingans y canjea el siguiente código '
                            + this.dataToShare.code +
                            '&url=' + '&hashtags='
                            + this.dataToShare.code + ',' + 'KINGANS';
                        break;
                    case 'whatsapp':
                        url = 'https://api.whatsapp.com/send?text=: ' + 'Descarga la app Kingans y canjea el siguiente código ' +
                            ' *' + this.dataToShare.code + '* ';
                        break;
                    case 'facebook':
                        url = 'https://www.facebook.com/sharer/sharer.php?' +
                            //'u=' + this.dataToShare.post_url +
                            '&title=' + this.dataToShare.name +
                            '&description=' + 'Descarga la app Kingans y canjea el siguiente código: ' +
                            this.dataToShare.code;
                        //'&quote=' + this.dataToShare.post_title;
                        break;
                }
                this.openBrowser(encodeURI(url))
            },
            openBrowser(url) {
                let options = "location=no,clearcache=yes,clearsessioncache=yes,zoom=yes,EnableViewPortScale=yes"
                let ref = cordova.InAppBrowser.open(url, '_self', options);
            },
            getCoupons: function () {
                this.$f7.dialog.preloader('Cargando...');
                this.$http.post(this.$store.state.application.config.api + 'coupons/get',
                    {user_id: this.$store.state.application.user.id}
                ).then(response => {
                    this.$f7.dialog.close();
                    this.items = response.data
                }, response => {
                    console.log(response, 'error on getCoupons coupons/get');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("", 'Servidor no disponible.');
                });
            },
            dateStringMX: function (arg) {
                let months = [
                    "ENERO",
                    "FEBRERO",
                    "MARZO",
                    "ABRIL",
                    "MAYO",
                    "JUNIO",
                    "JULIO",
                    "AGOSTO",
                    "SEPTIEMBRE",
                    "OCTUBRE",
                    "NOVIEMBRE",
                    "DICIEMBRE",
                ];
                let date = new Date(arg);
                let day = date.getDate();
                let month = months[date.getMonth()];
                let year = date.getFullYear();

                if (day.length < 2) {
                    day = '0' + day;
                }

                return month + " " + day + " / " + year;
            }
        },
    }
</script>

<style>
    .block-strong:before, .block-strong:after {
        content: none !important;
    }
</style>
<template>
    <f7-page login-screen>
        <f7-navbar title="Captura de Cupones y Visitas"
                   style="background-color: white !important;
                   border:none !important; box-shadow: none !important;" :sliding="true" back-link="Atrás">
            <f7-nav-right>
                <f7-link icon-ios="f7:menu"
                         icon-aurora="f7:menu"
                         icon-md="material:menu"
                         panel-open="left">
                </f7-link>
            </f7-nav-right>
        </f7-navbar>

        <f7-login-screen-title style="color: white;max-width: 200px">
            <div style="width: 100%">
                <img class="circle-image" style="width: 50%; margin-top: 40px" src="../../assets/logoKingans.svg"/>
            </div>
        </f7-login-screen-title>
        <f7-list form style="max-width: 350px">
            <f7-list-item style="width: 100%">
                <f7-list-input
                        style="width: 100%"
                        info="TELÉFONO DEL USUARIO"
                        class="kingans-border"
                        label="REGISTRAR VISITA"
                        type="number"
                        placeholder="XXX XXX XX XX"
                        :value="phone"
                        clear-button
                        @input="phone = $event.target.value"
                ></f7-list-input>
                <f7-button
                        class="btn-primary"
                        style="height: 74px;border-left: none;border-top-left-radius: 0px;border-bottom-left-radius: 0px;margin-left: -4px;"
                        large @click="sendVisitCode">
                    <f7-icon style="margin-top: 20px;font-size: 1.1em;" material="play_arrow"></f7-icon>
                </f7-button>
            </f7-list-item>
        </f7-list>
        <f7-list form style="max-width: 350px">
            <f7-list-item style="width: 100%">
                <f7-list-input
                        style="width: 100%"
                        class="kingans-border"
                        label="CANJEAR CÓDIGO"
                        info="CÓDIGO"
                        type="text"
                        placeholder="XXX XXX XX XX"
                        :value="coupon"
                        clear-button
                        @input="coupon = $event.target.value"
                ></f7-list-input>
                <f7-button
                        class="btn-primary"
                        style="height: 74px;border-left: none;border-top-left-radius: 0px;border-bottom-left-radius: 0px;margin-left: -4px;"
                        large @click="sendCouponCode">
                    <f7-icon style="margin-top: 20px;font-size: 1.1em;" material="play_arrow"></f7-icon>
                </f7-button>
            </f7-list-item>
        </f7-list>
        <f7-popup :closeByBackdropClick="false" :opened="popupOpened" @popup:closed="popupOpened = false">
            <f7-page>
                <f7-navbar :title="details.code">
                    <f7-nav-right>
                        <f7-link popup-close>Cerrar</f7-link>
                    </f7-nav-right>
                </f7-navbar>
                <f7-block>
                    <p>Leer antes de cerrar.</p>
                    <p>El siguiente código contiene:</p>
                    <p>{{details.description}}</p>
                </f7-block>
            </f7-page>
        </f7-popup>
    </f7-page>
</template>

<script>
    export default {
        name: "codeExchange",
        data() {
            return {
                phone: '',
                coupon: '',
                popupOpened: false,
                details: {name:'', code: '', description:''},
            };
        },
        methods: {
            sendVisitCode: function () {
                if (this.phone !== '') {
                    this.$f7.dialog.preloader('Enviando datos...');
                    this.$http.post(this.$store.state.application.config.api + 'visits/add', {
                        created_by: this.$store.state.application.user.id,
                        phone: this.phone
                    }).then(response => {
                        console.log(response.data)
                        this.$f7.dialog.close();
                        if (response.data.user_id === undefined) {
                            this.$f7.dialog.alert("Una visita al día por usuario.", "Datos duplicados");
                        } else {
                            this.$f7.dialog.alert("¡Visita registrada!", "Éxito");
                            this.phone = '';
                        }
                    }, response => {
                        console.log(response, 'error on checkForm coupons/add');
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Servidor no disponible y/o Datos duplicados", 'Intente más tarde');
                    });

                } else {
                    this.$f7.dialog.alert("Todos los campos son requeridos.");
                }
            },
            sendCouponCode: function () {
                if (this.phone !== '' && this.coupon !== '') {
                    this.$f7.dialog.preloader('Enviando datos...');
                    this.$http.post(this.$store.state.application.config.api + 'coupons/exchange', {
                        created_by: this.$store.state.application.user.id,
                        phone: this.phone,
                        code: this.coupon,
                    }).then(response => {
                        this.$f7.dialog.close();
                        if (response.data.id === undefined) {
                            this.$f7.dialog.alert(response.data.text, response.data.title);
                        } else {
                            this.$f7.dialog.alert("¡Código canjeado!", "Éxito");
                            this.details = response.data;
                            this.popupOpened = true;
                            this.phone = '';
                            this.coupon = '';
                        }
                    }, response => {
                        console.log(response, 'error on checkForm coupons/exchange');
                        this.$f7.dialog.close();
                        this.$f7.dialog.alert("Servidor no disponible y/o Datos duplicados", 'Intente más tarde');
                    });

                } else {
                    this.$f7.dialog.alert("Todos los campos son requeridos.");
                }
            }
        }
    }
</script>

<style scoped>
    .navbar:before {
        content: none !important;
    }
</style>
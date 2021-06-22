<template>
    <f7-app :params="f7params">
        <!-- Status bar overlay for fullscreen mode-->
        <f7-statusbar></f7-statusbar>

        <!-- Left panel with cover effect when hidden -->
        <f7-panel left cover resizable style="width: 300px">
            <f7-view>
                <f7-page>
                    <f7-block-title style="padding-bottom: 18px">
                        <img style="height: 80px; float:left" class="circle-image" src="../assets/logoKingans.svg">
                        <strong style="font-size: 1.4em;position: relative;top: 22px;left: 10px;">{{$store.state.application.user.name}}</strong><br/>
                        <strong style="font-size: .9em;position: relative;top: 25px;left: 10px;">Bienvenido</strong>
                    </f7-block-title>
                    <!--<f7-block-title>Acceso Rápido</f7-block-title>
                    <f7-list>
                        <f7-list-item link="/dashboard/" view=".view-main" panel-close title="Dashboard"></f7-list-item>
                        <f7-list-item link="/coupons/exchange/" view=".view-main" panel-close
                                      title="Captura de Códigos / Visitas"></f7-list-item>
                    </f7-list>-->
                    <f7-block-title>Catálogos</f7-block-title>
                    <f7-list accordion-list>
                        <f7-list-item accordion-item title="Promociones"
                                      v-if="$store.state.application.user.type === 'A'">
                            <f7-accordion-content>
                                <f7-list inset>
                                    <f7-list-item
                                            link="/news/add" view=".view-main" panel-close
                                            title="Añadir Promociones"
                                            subtitle="Catálogo">
                                    </f7-list-item>
                                    <f7-list-item
                                            link="/news/list" view=".view-main" panel-close
                                            title="Listar Promociones"
                                            subtitle="Catálogo">
                                    </f7-list-item>
                                </f7-list>
                            </f7-accordion-content>
                        </f7-list-item>
                        <!--<f7-list-item accordion-item title="Cupones">
                            <f7-accordion-content>
                                <f7-list inset>
                                    <f7-list-item
                                            v-if="$store.state.application.user.type === 'A'"
                                            link="/coupons/exchange/list" view=".view-main" panel-close
                                            title="Cupones Canjeados"
                                            subtitle="Catálogo">
                                    </f7-list-item>
                                    <f7-list-item
                                            v-if="$store.state.application.user.type === 'A'"
                                            link="/coupons/add" view=".view-main" panel-close
                                            title="Añadir Cupón"
                                            subtitle="Catálogo">
                                    </f7-list-item>
                                    <f7-list-item
                                            link="/coupons/list" view=".view-main" panel-close
                                            title="Listar Cupones"
                                            subtitle="Catálogo">
                                    </f7-list-item>
                                </f7-list>
                            </f7-accordion-content>
                        </f7-list-item>
                        <f7-list-item accordion-item title="Visitas">
                            <f7-accordion-content>
                                <f7-list inset>
                                    <f7-list-item
                                            link="/visits/list" view=".view-main" panel-close
                                            title="Listar Visitas"
                                            subtitle="Catálogo">
                                    </f7-list-item>
                                </f7-list>
                            </f7-accordion-content>
                        </f7-list-item>
                        <f7-list-item accordion-item title="Encuestas"
                                      v-if="$store.state.application.user.type === 'A'">
                            <f7-accordion-content>
                                <f7-list inset>
                                    <f7-list-item
                                            link="/surveys/add" view=".view-main" panel-close
                                            title="Añadir Encuesta"
                                            subtitle="Catálogo">
                                    </f7-list-item>
                                    <f7-list-item

                                            link="/surveys/list" view=".view-main" panel-close
                                            title="Listar Encuestas"
                                            subtitle="Catálogo">
                                    </f7-list-item>
                                </f7-list>
                            </f7-accordion-content>
                        </f7-list-item>-->
                        <f7-list-item accordion-item title="Usuarios Panel Kingans"
                                      v-if="$store.state.application.user.type === 'A'">
                            <f7-accordion-content>
                                <f7-list inset>
                                    <f7-list-item
                                            link="/users/panel/add" view=".view-main" panel-close
                                            title="Añadir Usuario"
                                            subtitle="Catálogo">
                                    </f7-list-item>
                                    <f7-list-item
                                            link="/users/panel/list" view=".view-main" panel-close
                                            title="Listar Usuarios"
                                            subtitle="Catálogo">
                                    </f7-list-item>
                                </f7-list>
                            </f7-accordion-content>
                        </f7-list-item>
                        <f7-list-item accordion-item title="Usuarios Aplicación Kingans"
                                      v-if="$store.state.application.user.type === 'A'||
                                                 $store.state.application.user.type === 'G'">
                            <f7-accordion-content>
                                <f7-list inset>
                                    <f7-list-item
                                            v-if="$store.state.application.user.type === 'A'"
                                            link="/users/app/add" view=".view-main" panel-close
                                            title="Añadir Usuario"
                                            subtitle="Catálogo">
                                    </f7-list-item>
                                    <f7-list-item
                                            v-if="$store.state.application.user.type === 'A'||
                                                 $store.state.application.user.type === 'G'"
                                            link="/users/app/list" view=".view-main" panel-close
                                            title="Listar Usuarios"
                                            subtitle="Catálogo">
                                    </f7-list-item>
                                </f7-list>
                            </f7-accordion-content>
                        </f7-list-item>
                        <f7-list-item accordion-item title="Sucursales"
                                      v-if="$store.state.application.user.type === 'A'">
                            <f7-accordion-content>
                                <f7-list inset>
                                    <f7-list-item
                                            link="/branches/add" view=".view-main" panel-close
                                            title="Añadir Sucursal"
                                            subtitle="Catálogo">
                                    </f7-list-item>
                                    <f7-list-item
                                            link="/branches/list" view=".view-main" panel-close
                                            title="Listar Sucursales"
                                            subtitle="Catálogo">
                                    </f7-list-item>
                                </f7-list>
                            </f7-accordion-content>
                        </f7-list-item>
                        <f7-list-item link="/logout/" view=".view-main" panel-close
                                      title="Cerrar Sesión"></f7-list-item>
                    </f7-list>
                </f7-page>
            </f7-view>
        </f7-panel>

        <f7-view v-if="!$store.state.application.drawer.login" main class="safe-areas" url="/"></f7-view>

        <f7-login-screen :opened="$store.state.application.drawer.login">
            <f7-view>
                <login/>
            </f7-view>
        </f7-login-screen>
    </f7-app>
</template>
<script>

    import routes from '../js/routes.js';
    import Login from "../pages/login";

    export default {
        components: {Login},
        data() {
            return {
                // Framework7 Parameters
                f7params: {
                    name: 'Panel Kingans', // App name
                    theme: 'auto', // Automatic theme detection
                    // App root data
                    data: function () {

                    },
                    // App routes
                    routes: routes,
                    // Enable panel left visibility breakpoint
                    panel: {},
                },

                // Login screen data
                username: '',
                password: '',
            }
        },
        methods: {},
        mounted() {
            this.$f7ready((f7) => {

                // Call F7 APIs here
            });
        }
    }
</script>

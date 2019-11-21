<template>
    <f7-app :params="f7params">
        <!-- Status bar overlay for fullscreen mode-->
        <f7-statusbar></f7-statusbar>

        <f7-panel left cover>
            <f7-view>
                <f7-page>

                    <f7-block-title>
                        <img style="width: 50px" class="circle-image" src="../assets/logoKingans.svg"/>
                    </f7-block-title>

                    <f7-block>
                        <span style="font-size: 1.6em;color: black;">{{$store.state.application.user.name}}</span><br/>
                        <span>{{$store.state.application.user.city}}</span>
                    </f7-block>

                    <f7-list :style="{
                            position: 'absolute',
                            width: '100%',
                            marginTop: ((window.height - 206) / 2) - 132 + 'px',
                            }">
                        <f7-list-item class="custom-btn" flat link="/"
                                      view=".view-main" v-ripple
                                      panel-close>
                            <f7-icon class="active" style="" material="favorite"></f7-icon>
                            <span class="active" style="
                                    font-size: 1.2em;
                            ">Home</span>
                        </f7-list-item>
                        <f7-list-item class="custom-btn" flat v-ripple
                                      link="/branches/" view=".view-main"
                                      panel-close>
                            <f7-icon style="" material="place"></f7-icon>
                            <span style="
                                    font-size: 1.2em;
                            ">Sucursales</span>
                        </f7-list-item>
                        <f7-list-item class="custom-btn" flat v-ripple
                                   link="/profile/" view=".view-main"
                                   panel-close>
                            <f7-icon style="" material="person"></f7-icon>
                            <span style="
                                    font-size: 1.2em;
                            ">Usuario</span>
                        </f7-list-item>
                    </f7-list>

                    <f7-list style="
                            position: absolute;
                            bottom: 0;
                            width: 100%;
                            margin: 0;">
                        <f7-list-item @click="$store.commit('resetLogin')" panel-close>
                            <f7-icon style="" material="close"></f7-icon>
                            <span style="
                                    position: absolute;
                                    margin-left: 42px;
                                    font-weight: 100;
                            ">Cerrar Sesión</span>
                        </f7-list-item>
                    </f7-list>
                </f7-page>
            </f7-view>
        </f7-panel>

        <!-- Your main view, should have "view-main" class -->
        <f7-view v-if="$store.state.application.user.id !== undefined" main class="safe-areas" url="/"></f7-view>

        <f7-login-screen
                :opened="$store.state.application.drawer.login"
                @loginscreen:closed="$store.state.application.drawer.login = false">
            <f7-view>
                <login/>
            </f7-view>
        </f7-login-screen>
    </f7-app>
</template>
<script>
    import cordovaApp from '../js/cordova-app.js';
    import routes from '../js/routes.js';
    import login from "../pages/login";

    export default {
        components: {login},
        data() {
            return {
                // Framework7 Parameters
                window: {
                    width: 0,
                    height: 0
                },
                f7params: {
                    id: 'com.kingans', // App bundle ID
                    name: 'Kingans', // App name
                    theme: 'ios', // Automatic theme detection
                    // App root data
                    data: function () {
                        return {
                            user: {
                                firstName: 'John',
                                lastName: 'Doe',
                            },
                        };
                    },
                    // App routes
                    routes: routes,
                    // Enable panel left visibility breakpoint
                    panel: {
                        leftBreakpoint: 960,
                    },
                    // Input settings
                    input: {
                        scrollIntoViewOnFocus: this.$device.cordova && !this.$device.electron,
                        scrollIntoViewCentered: this.$device.cordova && !this.$device.electron,
                    },
                    // Cordova Statusbar settings
                    statusbar: {
                        iosBackgroundColor: '#f16989',
                        androidBackgroundColor: '#f16989',
                        overlay: this.$device.cordova && this.$device.ios || 'auto',
                        iosOverlaysWebView: true,
                        androidOverlaysWebView: false,
                    },
                },

                // Login screen data
                username: '',
                password: '',
            }
        },
        created() {
            window.addEventListener('resize', this.handleResize)
            this.handleResize();
        },
        destroyed() {
            window.removeEventListener('resize', this.handleResize)
        },
        methods: {
            alertLoginData() {
                this.$f7.dialog.alert('Username: ' + this.username + '<br>Password: ' + this.password);
            },
            handleResize() {
                this.window.width = window.innerWidth;
                this.window.height = window.innerHeight;
            }
        },
        mounted() {
            this.$f7ready((f7) => {
                // Init cordova APIs (see cordova-app.js)
                if (f7.device.cordova) {
                    cordovaApp.init(f7);
                }
                // Call F7 APIs here
            });
        }
    }
</script>

<style scoped lang="scss">
    .custom-btn{
        margin: 0;
        padding: 0;
        text-align: left;
        border-radius: 0;
        width: 100%;
        height: 40px;
        i.icon{
            margin-top: 5px;
        }
        span{
            position: absolute;
            margin-left: 34px;
            margin-top: 2px;
            font-weight: 400;
        }
    }
    .active{
        color: #f16989;
    }

</style>
<style>
    .list ul:before, .list ul:after {
        content: none !important;
    }
    .simple-list li:after, .links-list a:after, .list .item-inner:after{
        content: none !important;
    }
    .list .item-link .item-inner:before, .links-list a:before, .media-list .item-link .item-title-row:before, li.media-item .item-link .item-title-row:before, .media-list.chevron-center .item-link .item-inner:before, .media-list .chevron-center .item-link .item-inner:before, .media-list .item-link.chevron-center .item-inner:before, li.media-item.chevron-center .item-link .item-inner:before, li.media-item .chevron-center .item-link .item-inner:before, li.media-item .item-link.chevron-center .item-inner:before{
        content: none !important;
    }
</style>
<template>
    <f7-page>
        <f7-navbar no-shadow no-hairline back-link="Atrás">
            <f7-nav-title>
                <img style="height: 25px" src="../assets/kingansWhite.svg">
            </f7-nav-title>
            <f7-nav-right>
                <f7-link @click="getCoupons">
                    <f7-icon style="" material="cached"></f7-icon>
                </f7-link>
            </f7-nav-right>
        </f7-navbar>
        <f7-block strong style="margin:0 ">
            <f7-row>
                <f7-col width="30">
                    <div class="bg-primary" style="
                        width: 75px;
                        height: 75px;
                        border-radius: 100%;
                        ">
                        <f7-icon style="color:white;font-size: 3em;margin: 16px;" material="new_releases"></f7-icon>
                    </div>
                </f7-col>
                <f7-col width="70">
                    <h1 v-if="$f7route.params.filter === 'true'" style="margin:0">Mis Premios</h1>
                    <h1 v-else style="margin:0">Premios</h1>
                    <span>CÓDIGOS</span>
                </f7-col>
            </f7-row>
        </f7-block>
        <f7-block v-if="$f7route.params.filter === 'true'">
            <f7-card class="elevation-2" v-for="(item, index) in items" :key="index"
                     v-if="parseInt($store.state.application.visits) >= item.required_number">
                <f7-card-header>
                    <img v-if="item.src !== null" style="width:100%" :src="$store.state.application.config.api + 'images/coupons/' + item.src" :alt="item.code">
                </f7-card-header>
                <f7-card-content>
                    <span class="active" style="">Código: </span>
                    <span style="font-size: 1.6em">#{{item.code}}</span>
                    <p style="color: #6e6e74">
                        {{item.description}}
                    </p>
                    <p v-if="item.branch_name" style="color: #6e6e74">
                        <strong>Sucursal: <span class="active">{{item.branch_name}}</span></strong><br/>
                        <strong>Visitas necesarias:</strong> {{item.required_number}}
                    </p>
                    <p v-else style="color: #6e6e74">
                        <strong>Sucursal:</strong> ¡Todas!<br/>
                        <strong>Visitas necesarias:</strong> {{item.required_number}}
                    </p>
                    <p>
                        <!--INICIA EN {{dateStringMX(item.start)}}<br/>-->
                        <span class="">
                        Válida hasta {{dateStringMX(item.end)}}
                    </span>
                    </p>
                </f7-card-content>
            </f7-card>
        </f7-block>
        <f7-block v-else>
            <f7-card class="elevation-2" v-for="(item, index) in items" :key="index">
                <f7-card-header>
                    <img v-if="item.src !== null" style="width:100%" :src="$store.state.application.config.api + 'images/coupons/' + item.src" :alt="item.code">
                </f7-card-header>

                <f7-card-content>
                    <span class="active" style="">Código: </span>
                    <span style="font-size: 1.6em">#{{item.code}}</span>
                    <p style="color: #6e6e74">
                        {{item.description}}
                    </p>
                    <p v-if="item.branch_name" style="color: #6e6e74">
                        <strong>Sucursal: <span class="active">{{item.branch_name}}</span></strong><br/>
                        <strong>Visitas necesarias:</strong> {{item.required_number}}
                    </p>
                    <p v-else style="color: #6e6e74">
                        <strong>Sucursal:</strong> ¡Todas!<br/>
                        <strong>Visitas necesarias:</strong> {{item.required_number}}
                    </p>
                    <p>
                        <!--INICIA EN {{dateStringMX(item.start)}}<br/>-->
                        <span class="">
                        Válida hasta {{dateStringMX(item.end)}}
                    </span>
                    </p>
                </f7-card-content>
            </f7-card>
        </f7-block>
    </f7-page>
</template>

<script>
    export default {
        name: "promotions",
        data() {
            return {
                items: [],
            }
        },
        mounted: function () {
            this.getCoupons();
            let vm = this;
            document.addEventListener('backbutton', function (e) {
                vm.$f7router.navigate('/')
            }, false);

            //console.log(this.$f7route.params.filter)
        },
        methods: {
            getCoupons: function () {
                this.$f7.dialog.preloader('Cargando...');
                this.$http.post(this.$store.state.application.config.api + 'coupons/get',
                    {user_id: this.$store.state.application.user.id}
                ).then(response => {
                    this.$f7.dialog.close();
                    this.items = response.data
                    //console.log(this.items)
                }, response => {
                    console.log(response, 'error on getCoupons coupons/get');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("", 'Servidor no disponible.');
                });
            },
            dateStringMX: function (arg) {
                let months = [
                    "Enero",
                    "Febrero",
                    "Marzo",
                    "Abril",
                    "Mayo",
                    "Junio",
                    "Julio",
                    "Agosto",
                    "Septiembre",
                    "Octubre",
                    "Noviembre",
                    "Diciembre",
                ];
                let date = new Date(arg);
                let day = date.getDate();
                let month = months[date.getMonth()];
                let year = date.getFullYear();

                if (day.length < 2) {
                    day = '0' + day;
                }

                return month + " " + day + " del " + year;
            }
        },
    }
</script>

<style>
    .block-strong:before, .block-strong:after {
        content: none !important;
    }
</style>
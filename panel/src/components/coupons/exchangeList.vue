<template>
    <f7-page name="surveys">
        <f7-navbar :sliding="true" back-link="Atrás" title="Lista de cupones canjeados">
            <f7-nav-right>
                <f7-link @click="getList">
                    <f7-icon material="cached"></f7-icon>
                </f7-link>
                <f7-link icon-ios="f7:menu"
                         icon-aurora="f7:menu"
                         icon-md="material:menu"
                         panel-open="left">
                </f7-link>
            </f7-nav-right>
        </f7-navbar>
        <f7-card>
            <f7-card-content style="padding-top:35px; padding-bottom:35px">
                <f7-block>
                    <f7-row>
                        <f7-col>
                            <vue-good-table
                                    title="Cupones Canjeados"
                                    :columns="columns"
                                    :fixed-header="true"
                                    :rows="rows"
                                    :paginate="true"
                                    :search-options="{enabled: true}"/>
                        </f7-col>
                    </f7-row>
                </f7-block>
            </f7-card-content>
        </f7-card>
    </f7-page>
</template>

<script>
    export default {
        name: "visitsList",
        data() {
            return {
                search: '',
                columns: [
                    {
                        label: 'Nombre',
                        field: 'user_name',
                        filterTextInput: true
                    },
                    {
                        label: 'Código',
                        field: 'coupon_code',
                        filterTextInput: true
                    },
                    {
                        label: 'Teléfono',
                        field: 'user_phone',
                        filterTextInput: true
                    },
                    {
                        label: 'E-mail',
                        field: 'user_email',
                        filterTextInput: true
                    },
                    {
                        label: 'Ciudad',
                        field: 'user_city',
                        filterTextInput: true
                    },
                    {
                        label: 'Género',
                        field: 'user_gender',
                        filterTextInput: true
                    },
                    {
                        label: 'Cumpleaños',
                        field: 'user_birthday',
                        filterTextInput: true
                    },
                    {
                        label: 'Día de Canje',
                        field: 'created_at',
                        filterTextInput: true
                    },
                    {
                        label: 'Canjeado por',
                        field: 'created_by',
                        filterTextInput: true
                    },

                ],
                rows: [

                ],
            }
        },
        computed: {
            filteredList() {
                return this.rows.filter(item => {
                    return item.user_name.toLowerCase().includes(this.search.toLowerCase())
                })
            },
        },
        created: function () {

        },
        mounted: function () {
            this.getList()
        },
        methods: {
            getList() {
                let vm = this
                vm.$f7.dialog.preloader('Obteniendo datos...');
                this.$http.post(this.$store.state.application.config.api + 'coupons/exchanges').then(response => {
                    vm.$f7.dialog.close();
                    vm.rows = response.data
                }, response => {
                    console.log(response, 'error on getList coupons/exchanges');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            }
        }
    }
</script>

<style scoped>

</style>
<template>
    <f7-page name="newsList">
        <f7-navbar :sliding="true" back-link="Atrás" title="Listado de Noticias">
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
        <f7-block>
            <f7-card>
                <f7-card-content>
                    <f7-block>
                        <f7-row>
                            <f7-col>
                                <f7-list form style="margin: 15px;max-width: 100%;">
                                    <f7-list-input
                                            class="kingans-border"
                                            label="Buscar por Nombre"
                                            placeholder="EJ: Lucas K."
                                            type="text"
                                            :value="search"
                                            clear-button
                                            @input="search = $event.target.value"
                                    ></f7-list-input>
                                </f7-list>
                            </f7-col>
                        </f7-row>
                    </f7-block>
                </f7-card-content>
            </f7-card>
        </f7-block>
        <f7-block>
            <f7-row>
                <f7-col>
                    <f7-card v-for="(item, key) in filteredList" :key="key">
                        <f7-card-header
                                class="no-border"
                                valign="bottom"
                        >
                            <strong>{{item.title}}</strong>
                            <p>
                                <img style="width:32px"
                                     :src="$store.state.application.config.api + 'images/branches/'+item.svg" alt="">
                                {{item.name}}
                            </p>
                        </f7-card-header>
                        <f7-card-content>
                            <img :src="$store.state.application.config.api + 'images/news/'+item.src"
                                 alt=""
                                 style="width:100%"
                            >
                        </f7-card-content>
                        <f7-card-footer>
                            <f7-link @click="deleteItem(item.id)">
                                <f7-icon class="icon-btn" material="delete"></f7-icon>
                                Eliminar
                            </f7-link>
                        </f7-card-footer>
                    </f7-card>
                </f7-col>
            </f7-row>
        </f7-block>
    </f7-page>
</template>

<script>
    export default {
        name: "newsList",
        data() {
            return {
                items: [],
                search: '',
            }
        },
        computed: {
            filteredList() {
                return this.items.filter(item => {
                    return item.title.toLowerCase().includes(this.search.toLowerCase())
                })
            },
        },
        mounted: function () {
            this.getList()
        },
        methods: {
            getList() {
                let vm = this
                vm.$f7.dialog.preloader('Obteniendo datos...');
                this.$http.post(this.$store.state.application.config.api + 'news/get').then(response => {
                    vm.$f7.dialog.close();
                    vm.items = response.data
                }, response => {
                    console.log(response, 'error on getList news/get');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
            deleteItem(id) {
                let vm = this;

                vm.$f7.dialog.preloader('Enviando datos...');
                this.$http.post(this.$store.state.application.config.api + 'news/delete', {
                    id: id
                }).then(response => {
                    vm.$f7.dialog.close();
                    if (response.data.success) {
                        vm.$f7.dialog.alert("Elemento Eliminado", 'Éxito');
                    } else {
                        vm.$f7.dialog.alert("Error desconocido", 'Intente más tarde');
                    }
                    vm.$f7.dialog.close();

                    this.getList();

                    //this.items = response.data
                }, response => {
                    console.log(response, 'error on checkForm news/delete');
                    this.$f7.dialog.close();
                    this.$f7.dialog.alert("Servidor no disponible", 'Intente más tarde');
                });
            },
        }
    }
</script>

<style scoped>

</style>

<template>
    <f7-page name="panelUsersList">
        <f7-navbar :sliding="true" back-link="Atrás" title="Listado de Usuarios del Panel">
            <f7-nav-right>
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
                    <f7-list style="margin: 8px;">
                        <f7-list-item>
                            <span><strong>Username</strong></span>
                            <span><strong>Nombre</strong></span>
                            <span><strong>Sucursal/Ciudad</strong></span>
                            <span><strong>Tipo</strong></span>
                            <span><strong>Creado Por</strong></span>
                            <span>Acciones</span>
                        </f7-list-item>
                        <f7-list-item v-for="item in filteredList">
                            <span>{{item.username}}</span>
                            <span>{{item.name}}</span>
                            <span><strong>{{item.branch_name}}</strong> / {{item.city}}</span>
                            <span>{{item.type}}</span>
                            <span>{{item.created_by_username}}</span>
                            <span>
                                <f7-icon class="icon-btn" material="edit"></f7-icon>
                                <f7-icon class="icon-btn" material="delete"></f7-icon>
                            </span>
                        </f7-list-item>
                    </f7-list>
                </f7-card-content>
            </f7-card>
        </f7-block>
    </f7-page>
</template>

<script>
    export default {
        name: "panelUsersList",
        data() {
            return {
                search: '',
                items: [
                    {
                        username: 'Admin001',
                        name: 'Lucas K.',
                        branch_name: 'Colón',
                        city: 'Torreón',
                        type: 'A',
                        created_by_username: 'Admin000'
                    },
                    {
                        username: 'Admin001',
                        name: 'Fake Name K.',
                        branch_name: 'Colón',
                        city: 'Torreón',
                        type: 'G',
                        created_by_username: 'Admin000'
                    },
                ]
            }
        },
        computed: {
            filteredList() {
                return this.items.filter(item => {
                    return item.name.toLowerCase().includes(this.search.toLowerCase())
                })
            },
        },
        mounted: function () {
        },
        methods: {},
    }
</script>

<style scoped>

</style>

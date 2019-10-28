<template>
    <f7-page name="panelUsersAdd">
        <f7-navbar :sliding="true" back-link="Atrás" title="Añadir Usuario al Panel">
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
                                label="Nombre de usuario"
                                placeholder="EJ: ADMIN001"
                                type="text"
                                info="Obligatorio"
                                :value="name"
                                clear-button
                                @input="name = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Nombre del usuario"
                                placeholder="EJ: Lucas K."
                                type="text"
                                info="Obligatorio"
                                :value="username"
                                clear-button
                                @input="username = $event.target.value"
                        ></f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Sucursal"
                                type="select"
                                info="Obligatorio"
                                placeholder="Sucursal"
                                :value="branchId"
                                @input="branchId = $event.target.value"
                        >
                            <option value="Saltillo">Saltillo</option>
                            <option value="Torreón">Torreón</option>
                        </f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Tipo"
                                type="select"
                                info="Obligatorio"
                                placeholder="Tipo de usuario"
                                :value="type"
                                @input="type = $event.target.value"
                        >
                            <option value="A">Administrador</option>
                            <option value="G">Gerente</option>
                            <option value="S">Supervisor</option>
                        </f7-list-input>
                        <f7-list-input
                                class="kingans-border"
                                label="Contraseña"
                                type="text"
                                placeholder="**********"
                                info="Obligatorio"
                                :value="password"
                                clear-button
                                @input="password = $event.target.value"
                        ></f7-list-input>
                    </f7-list>
                    <f7-button style="margin: 15px"
                               class="btn-primary"
                               large @click="">
                        REGISTRAR USUARIO AL PANEL
                    </f7-button>
                </f7-card-content>
            </f7-card>
        </f7-block>
    </f7-page>
</template>

<script>
    export default {
        name: "panelUsersAdd",
        data() {
            return {
                username: '',
                name: '',
                branchId: '',
                type: '',
                password: '',
            }
        },
        mounted: function () {
        },
        methods: {},
    }
</script>

<style scoped>

</style>

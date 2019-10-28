<template>
    <f7-page name="users">
        <f7-navbar :sliding="true" back-link="Atrás" title="Usuarios">
            <f7-nav-right>
                <f7-link icon-ios="f7:menu"
                         icon-aurora="f7:menu"
                         icon-md="material:menu"
                         panel-open="left">
                </f7-link>
            </f7-nav-right>
        </f7-navbar>
        <f7-row style="margin: 15px">
            <f7-col width="50">
                <f7-list simple-list style="max-width: 100%;">
                    <f7-list-item v-for="user in users">
                        <f7-icon material="delete"></f7-icon>
                        <strong>{{user.name}}</strong>
                        Supervisor
                    </f7-list-item>
                </f7-list>
            </f7-col>
            <f7-col width="50">
                <f7-card>
                    <f7-card-content>
                        <f7-list form style="margin: 15px;max-width: 100%;">
                            <f7-list-input
                                    class="kingans-border"
                                    label="Nombre de usuario"
                                    placeholder="Nombre de usuario"
                                    type="text"
                                    info="Obligatorio"
                                    :value="addUserForm.username"
                                    clear-button
                                    @input="addUserForm.username = $event.target.value"
                            ></f7-list-input>
                            <f7-list-input
                                    class="kingans-border"
                                    label="Sucursal"
                                    type="select"
                                    info="Obligatorio"
                                    placeholder="Sucursal"
                                    :value="addUserForm.branch"
                                    @input="addUserForm.branch = $event.target.value"
                            >
                                <option value="Saltillo">Saltillo</option>
                                <option value="Torreón">Torreón</option>
                            </f7-list-input>
                            <f7-list-input
                                    class="kingans-border"
                                    label="Contraseña"
                                    type="text"
                                    placeholder="**********"
                                    info="Obligatorio"
                                    :value="addUserForm.password"
                                    clear-button
                                    @input="addUserForm.password = $event.target.value"
                            ></f7-list-input>
                        </f7-list>
                        <f7-button style="margin: 15px"
                                   class="btn-primary"
                                   large @click="">
                            <f7-icon style="margin-top: -4px" material="person"></f7-icon>
                            REGISTRAR
                        </f7-button>
                    </f7-card-content>
                </f7-card>
            </f7-col>
        </f7-row>
    </f7-page>
</template>

<script>
    export default {
        name: "users",
        data() {
            return {
                addUserForm: {
                    username: "",
                    branch: "",
                    password: ""
                },
                users: [
                    {
                        name: "Lorem ipsum dolor"
                    },
                    {
                        name: "Tofu shabby chicd"
                    },
                    {
                        name: "Taiyaki typewrite"
                    },
                    {
                        name: "Copper mug intell"
                    },
                    {
                        name: "Cloud bread fannys"
                    },
                    {
                        name: "Tumeric raclette p"
                    },
                    {
                        name: " Man braid blog ac"
                    },
                    {
                        name: " XOXO raw denim va"
                    }
                ],
            }
        }
    }
</script>

<style scoped>

</style>
<template>
    <f7-page login-screen>
        <f7-navbar title="Panel Gerente">
            <f7-nav-right>
                <f7-link popup-close>X</f7-link>
            </f7-nav-right>

        </f7-navbar>
        <f7-subnavbar style="background-color: white">
            <f7-segmented raised>
                <f7-button tab-link="#home-M-tab" tab-link-active>Home</f7-button>
                <f7-button tab-link="#users-M-tab">Administrar Personal</f7-button>
                <f7-button tab-link="#surveys-M-tab">Revisar Encuestas</f7-button>
            </f7-segmented>
        </f7-subnavbar>
        <f7-tabs>
            <f7-tab id="home-M-tab" tab-active class="">
                <f7-block-title style="font-weight: bold">
                    Información de tienda "Kingans Saltillo" últimos 30 días
                </f7-block-title>
                <f7-row style="margin: 15px">
                    <f7-col>
                        <f7-card>
                            <f7-card-header>
                                <h4>Visitas</h4>
                            </f7-card-header>
                            <f7-card-content>
                                <strong class="card-number">155</strong>
                                <span class="card-date">05/08/1998</span>
                            </f7-card-content>
                        </f7-card>
                    </f7-col>

                    <f7-col>
                        <f7-card>
                            <f7-card-header>
                                <h4>Códigos canjeados</h4>
                            </f7-card-header>
                            <f7-card-content>
                                <strong class="card-number">155</strong>
                                <span class="card-date">05/08/1998</span>
                            </f7-card-content>
                        </f7-card>
                    </f7-col>
                    <f7-col>
                        <f7-card>
                            <f7-card-header>
                                <h4>Encuestas Contestadas</h4>
                            </f7-card-header>
                            <f7-card-content>
                                <strong class="card-number">155</strong>
                                <span class="card-date">05/08/1998</span>
                            </f7-card-content>
                        </f7-card>
                    </f7-col>
                </f7-row>
                <f7-row style="margin: 15px">
                    <f7-col>
                        <f7-messages ref="messages">
                            <f7-messages-title><b>Sunday, Feb 9,</b> 12:58</f7-messages-title>
                            <f7-message
                                    v-for="(message, index) in messagesData"
                                    :key="index"
                                    :type="message.type"
                                    :image="message.image"
                                    :name="message.name"
                                    :avatar="message.avatar"
                                    :first="isFirstMessage(message, index)"
                                    :last="isLastMessage(message, index)"
                                    :tail="isTailMessage(message, index)"
                            >
                                <span slot="text" v-if="message.text" v-html="message.text"></span>
                            </f7-message>
                        </f7-messages>
                    </f7-col>
                    <f7-col>
                        <f7-messages ref="messages">
                            <f7-messages-title><b>Sunday, Feb 10,</b> 12:58</f7-messages-title>
                            <f7-message
                                    v-for="(message, index) in messagesData"
                                    :key="index"
                                    :type="message.type"
                                    :image="message.image"
                                    :name="message.name"
                                    :avatar="message.avatar"
                                    :first="isFirstMessage(message, index)"
                                    :last="isLastMessage(message, index)"
                                    :tail="isTailMessage(message, index)"
                            >
                                <span slot="text" v-if="message.text" v-html="message.text"></span>
                            </f7-message>
                        </f7-messages>
                    </f7-col>
                    <f7-col>
                        <f7-messages ref="messages">
                            <f7-messages-title><b>Sunday, Feb 11,</b> 12:58</f7-messages-title>
                            <f7-message
                                    v-for="(message, index) in messagesData"
                                    :key="index"
                                    :type="message.type"
                                    :image="message.image"
                                    :name="message.name"
                                    :avatar="message.avatar"
                                    :first="isFirstMessage(message, index)"
                                    :last="isLastMessage(message, index)"
                                    :tail="isTailMessage(message, index)"
                            >
                                <span slot="text" v-if="message.text" v-html="message.text"></span>
                            </f7-message>
                        </f7-messages>
                    </f7-col>
                </f7-row>
            </f7-tab>
            <f7-tab id="users-M-tab">
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
            </f7-tab>
            <f7-tab id="surveys-M-tab" class="page-content"></f7-tab>
        </f7-tabs>
    </f7-page>
</template>


<script>
    export default {
        name: "managerIndex",
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
                messagesData: [
                    {
                        name: 'Usuario 1',
                        type: 'received',
                        text: 'Me salió un tornillo en el café blah blah blah',
                        avatar: 'http://kingans.com/imgs/logo-para-dentro.png',
                    }, {
                        name: 'Usuario 2',
                        type: 'received',
                        text: 'Me salió un tornillo en el café blah blah blah',
                        avatar: 'http://kingans.com/imgs/logo-para-dentro.png',
                    }, {
                        name: 'Usuario 3',
                        type: 'received',
                        text: 'Me salió un tornillo en el café blah blah blah',
                        avatar: 'http://kingans.com/imgs/logo-para-dentro.png',
                    }, {
                        name: 'Usuario 4',
                        type: 'received',
                        text: 'Me salió un tornillo en el café blah blah blah',
                        avatar: 'http://kingans.com/imgs/logo-para-dentro.png',
                    },
                ]
            };
        },
        mounted() {
            const self = this;
            self.$f7ready(() => {
                self.messagebar = self.$refs.messagebar.f7Messagebar;
                self.messages = self.$refs.messages.f7Messages;
            });
        },
        methods: {
            isFirstMessage(message, index) {
                const self = this;
                const previousMessage = self.messagesData[index - 1];
                if (message.isTitle) return false;
                if (!previousMessage || previousMessage.type !== message.type || previousMessage.name !== message.name) return true;
                return false;
            },
            isLastMessage(message, index) {
                const self = this;
                const nextMessage = self.messagesData[index + 1];
                if (message.isTitle) return false;
                if (!nextMessage || nextMessage.type !== message.type || nextMessage.name !== message.name) return true;
                return false;
            },
            isTailMessage(message, index) {
                const self = this;
                const nextMessage = self.messagesData[index + 1];
                if (message.isTitle) return false;
                if (!nextMessage || nextMessage.type !== message.type || nextMessage.name !== message.name) return true;
                return false;
            },
        }
    }
</script>

<style scoped>
    .button-fill, .ios .button-fill-ios, .md .button-fill-md, .aurora .button-fill-aurora, .button-active, .button.tab-link-active {
        background-color: #f16989;
        color: black;
    }

    .card-date {
        float: right;
    }

    .card-number {
        font-size: 4em;
    }

    .simple-list li {
        border-bottom: 1px solid black;
    }
</style>
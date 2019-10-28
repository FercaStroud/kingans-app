<template>
    <f7-page name="dashboard">
        <f7-navbar :sliding="true" back-link="Atrás" title="Dashboard">
            <f7-nav-right>
                <f7-link icon-ios="f7:menu"
                         icon-aurora="f7:menu"
                         icon-md="material:menu"
                         panel-open="left">
                </f7-link>
            </f7-nav-right>
        </f7-navbar>
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

    </f7-page>
</template>


<script>
    export default {
        name: "dashboard",
        data() {
            return {
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
                ],
            };
        },
        mounted() {
            const self = this;
            //self.$f7ready(() => {
            //    self.messagebar = self.$refs.messagebar.f7Messagebar;
            //    self.messages = self.$refs.messages.f7Messages;
            //});
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
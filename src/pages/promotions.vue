<template>
    <f7-page>
        <f7-navbar back-link="Atrás"></f7-navbar>
        <f7-block strong style="margin:0 ">
            <f7-row>
                <f7-col width="30">
                    <div style="
                        width: 75px;
                        height: 75px;
                        border-radius: 100%;
                        background-color: #f6b05d
                        ">
                        <f7-icon style="font-size: 3em;margin: 16px;" material="new_releases"></f7-icon>
                    </div>
                </f7-col>
                <f7-col width="70">
                    <h1 style="margin:0">Promociones</h1>
                    <span>CÓDIGOS</span>
                </f7-col>
            </f7-row>
        </f7-block>

        <f7-card class="elevation-2">
            <f7-card-header>
                <img style="width: 100%" src="https://via.placeholder.com/348x196"/>
            </f7-card-header>
            <f7-card-content>
                <p>
                    <span style="font-size: 1.6em">CODIGO:</span><br/>
                    <span style="font-size: .9em">FRAPPE2X1</span>
                </p>
                <p style="color: #6e6e74">
                    Lorem Ipsum dolor sit ametLorem Ipsum dolor sit ametLorem Ipsum dolor sit amet
                </p>
            </f7-card-content>
            <f7-card-footer>
                <f7-link style="color: #d73057; font-weight: bold">23/07</f7-link>
                <f7-link style="font-weight: bold">VIGENCIA</f7-link>
            </f7-card-footer>
        </f7-card>

        <f7-card class="elevation-2">
            <f7-card-header>
                <img style="width: 100%" src="https://via.placeholder.com/348x196"/>
            </f7-card-header>
            <f7-card-content>
                <p>
                    <span style="font-size: 1.6em">CODIGO:</span><br/>
                    <span style="font-size: .9em">FRAPPE2X1</span>
                </p>
                <p style="color: #6e6e74">
                    Lorem Ipsum dolor sit ametLorem Ipsum dolor sit ametLorem Ipsum dolor sit amet
                </p>
            </f7-card-content>
            <f7-card-footer>
                <f7-link style="color: #d73057; font-weight: bold">23/07</f7-link>
                <f7-link style="font-weight: bold">VIGENCIA</f7-link>
            </f7-card-footer>
        </f7-card>

        

    </f7-page>
</template>

<script>
    export default {
        name: "promotions"
    }
</script>

<style >
    .block-strong:before, .block-strong:after{
        content: none !important;
    }
</style>
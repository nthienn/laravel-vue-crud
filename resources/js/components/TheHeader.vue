<template lang="">
    <div class="container-fluid">
        <div
            class="row text-white"
            style="background-color: #0c713d; padding: 1rem"
        >
            <div
                class="col-1 d-flex d-sm-none align-items-center justify-content-center"
            >
                <span @click="showDrawer()"><MenuOutlined /></span>
            </div>

            <div
                class="col-10 col-sm-9 d-flex align-items-center justify-content-center justify-content-sm-start"
            >
                <img
                    src="https://upload.wikimedia.org/wikipedia/commons/thumb/9/95/Vue.js_Logo_2.svg/1184px-Vue.js_Logo_2.svg.png"
                    alt="logo"
                    height="32"
                    width="34"
                    class="ms-3 me-3"   
                />
                <span class="d-none d-sm-flex">QUẢN TRỊ</span>
            </div>

            <div
                class="col-sm-3 d-none d-sm-flex align-items-center justify-content-sm-end"
            >
                <span>ADMIN</span>
            </div>

            <div
                class="col-1 d-flex d-sm-none align-items-center justify-content-center"
            >
                <span @click="showDrawerUser()"><UserOutlined /></span>
            </div>
        </div>
    </div>

    <a-drawer v-model:visible="visible" title="Danh mục" placement="left">
        <TheMenu />
    </a-drawer>

    <a-drawer v-model:visible="visible_user" title="Admin" placement="right">
        <p>Some contents...</p>
        <p>Some contents...</p>
        <p>Some contents...</p>
    </a-drawer>
</template>

<script>
import TheMenu from "./TheMenu.vue";
import { MenuOutlined, UserOutlined } from "@ant-design/icons-vue";
import { defineComponent, ref } from "vue";

export default defineComponent({
    components: {
        TheMenu,
        MenuOutlined,
        UserOutlined,
    },
    setup() {
        const visible = ref(false);
        const visible_user = ref(false);

        const showDrawer = () => {
            visible.value = true;
        };

        const showDrawerUser = () => {
            visible_user.value = true;
        };

        return {
            visible,
            visible_user,
            showDrawer,
            showDrawerUser,
        };
    },
});
</script>

<style lang=""></style>

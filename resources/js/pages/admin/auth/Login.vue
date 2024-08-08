<template lang="">
    <div class="form-login">
        <form
            @submit.prevent="loginAdmin()"
            class="position-absolute top-50 start-50 translate-middle"
        >
            <a-card title="LOG IN" style="width: 100%">
                <div class="row mb-3">
                    <div class="col-12 col-sm-4 text-start text-sm-end">
                        <label>
                            <span class="text-danger me-1">*</span>
                            <span
                                :class="{
                                    'text-danger': errors.email,
                                }"
                            >
                                Email:
                            </span>
                        </label>
                    </div>
                    <div class="col-12 col-sm-8">
                        <a-input
                            placeholder="Email"
                            allow-clear
                            v-model:value="email"
                            :class="{
                                'border-danger': errors.email,
                            }"
                        />
                        <div class="w-100"></div>
                        <small v-if="errors.email" class="text-danger">
                            {{ errors.email[0] }}
                        </small>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-12 col-sm-4 text-start text-sm-end">
                        <label>
                            <span class="text-danger me-1">*</span>
                            <span
                                :class="{
                                    'text-danger': errors.password,
                                }"
                            >
                                Password:
                            </span>
                        </label>
                    </div>
                    <div class="col-12 col-sm-8">
                        <a-input-password
                            placeholder="Password"
                            allow-clear
                            v-model:value="password"
                            :class="{
                                'border-danger': errors.password,
                            }"
                        />
                        <div class="w-100"></div>
                        <small v-if="errors.password" class="text-danger">
                            {{ errors.password[0] }}
                        </small>
                    </div>
                </div>
                <div class="row">
                    <div
                        class="col-12 d-grid d-sm-flex justify-content-sm-end mx-auto"
                    >
                        <a-button type="primary" html-type="submit">
                            <span>Log in</span>
                        </a-button>
                    </div>
                </div>
            </a-card>
        </form>
    </div>
</template>

<script>
import { defineComponent, reactive, ref, toRefs } from "vue";
import { useRouter } from "vue-router";
import { message } from "ant-design-vue";

export default defineComponent({
    setup() {
        const router = useRouter();

        const auth = reactive({
            email: "",
            password: "",
        });
        
        const errors = ref([]);

        const loginAdmin = () => {
            axios
                .post("http://127.0.0.1:8000/api/login", auth)
                .then(function (response) {
                    if (response.data.status == true) {
                        router.push({ name: "admin" });
                    } else {
                        message.error("Login failed! Please try again.");
                    }
                })
                .catch(function (error) {
                    errors.value = error.response.data.errors;
                });
        };

        return {
            ...toRefs(auth),
            errors,
            loginAdmin,
        };
    },
});
</script>

<style lang="css" scoped>
.form-login {
    background: #456;
    width: 100vw;
    height: 100vh;
}

.border-danger {
    border: 1px solid red;
}
</style>

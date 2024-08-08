<template lang="">
    <a-card title="Tài khoản" style="width: 100%">
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-end">
                <a-button type="primary">
                    <router-link :to="{ name: 'admin-users-create' }">
                        <PlusOutlined></PlusOutlined>
                    </router-link>
                </a-button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <a-table
                    :dataSource="users"
                    :columns="columns"
                    :scroll="{ x: 576 }"
                >
                    <template #bodyCell="{ column, index, record }">
                        <template v-if="column.key === 'index'">
                            <span>{{ index + 1 }}</span>
                        </template>

                        <template v-if="column.key === 'status'">
                            <span
                                v-if="record.status_id == 1"
                                class="text-primary"
                            >
                                {{ record.status }}
                            </span>
                            <span
                                v-else-if="record.status_id == 2"
                                class="text-danger"
                            >
                                {{ record.status }}
                            </span>
                        </template>

                        <template v-if="column.key === 'action'">
                            <router-link
                                :to="{
                                    name: 'admin-users-edit',
                                    params: { id: record.id },
                                }"
                            >
                                <a-button type="primary" class="me-sm-2 mb-2">
                                    <EditOutlined></EditOutlined>
                                </a-button>
                            </router-link>

                            <a-button
                                type="primary"
                                danger
                                @click="deleteUser(record.id)"
                            >
                                <DeleteOutlined></DeleteOutlined>
                            </a-button>
                        </template>
                    </template>
                </a-table>
            </div>
        </div>
    </a-card>
</template>

<script>
import {
    PlusOutlined,
    EditOutlined,
    DeleteOutlined,
    ExclamationCircleOutlined,
} from "@ant-design/icons-vue";
import { defineComponent, ref, createVNode } from "vue";
import { useMenu } from "../../../stores/use-menu";
import { Modal, message } from "ant-design-vue";

export default defineComponent({
    components: {
        PlusOutlined,
        EditOutlined,
        DeleteOutlined,
    },
    setup() {
        const store = useMenu();
        store.onSelectedKeys(["admin-users"]);

        const users = ref([]);
        const columns = [
            {
                title: "#",
                key: "index",
            },
            {
                title: "Avatar",
                key: "avatar",
            },
            {
                title: "Tài khoản",
                dataIndex: "username",
                key: "username",
            },
            {
                title: "Họ tên",
                dataIndex: "name",
                key: "name",
            },
            {
                title: "Phòng ban",
                dataIndex: "department",
                key: "department",
            },
            {
                title: "Vai trò",
                key: "role",
            },
            {
                title: "Tình trạng",
                dataIndex: "status",
                key: "status",
            },
            {
                title: "Công cụ",
                key: "action",
                fixed: "right",
            },
        ];

        const getUsers = () => {
            axios
                .get("http://127.0.0.1:8000/api/users")
                .then(function (response) {
                    users.value = response.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
        };

        const deleteUser = (id) => {
            Modal.confirm({
                content: "Bạn có chắc chắn?",
                icon: createVNode(ExclamationCircleOutlined),
                onOk() {
                    axios
                        .delete(`http://127.0.0.1:8000/api/users/${id}`)
                        .then(function (response) {
                            if (response.status == 200) {
                                message.success("Xoá tài khoản thành công");
                                getUsers();
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                cancelText: "Huỷ",
                onCancel() {
                    Modal.destroyAll();
                },
            });
        };

        getUsers();

        return {
            users,
            columns,
            deleteUser,
        };
    },
});
</script>

<style lang=""></style>

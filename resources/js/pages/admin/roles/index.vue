<template lang="">
    <div>
        Roles
    </div>
</template>

<script>
import { useMenu } from "../../../stores/use-menu";

export default {
    setup() {
        const store = useMenu();
        store.onSelectedKeys(["admin-roles"]);
    },
};
</script>

<style lang="">
    
</style>
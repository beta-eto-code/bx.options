<template>
    <el-collapse-item label="User" name="first">
        <component-builder :nodes="node.children"></component-builder>
    </el-collapse-item>
</template>

<script>
export default {
    name: "vue-collapse",
    props: ["node"],
}
</script>

<style scoped>

</style>

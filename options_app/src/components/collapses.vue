<template>
    <el-collapse>
        <el-collapse-item
                v-for="(collapse, i) in collapses"
                :key="i"
                :title="collapse.properties.name"
                :name="i.toString()">
            <component-builder :nodes="collapse.children"></component-builder>
        </el-collapse-item>
    </el-collapse>
</template>

<script>
export default {
    name: "vue-collapses",
    props: ["node"],
    computed: {
        collapses() {
            return this.node.children.filter((node) => node.type === "collapse");
        }
    }
}
</script>

<style scoped>

</style>

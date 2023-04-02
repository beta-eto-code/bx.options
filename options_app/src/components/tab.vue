<template>
  <el-tab-pane label="User" name="first">
    <component-builder :nodes="node.children"></component-builder>
  </el-tab-pane>
</template>

<script>
export default {
  name: "vue-tab",
  props: ["node"],
}
</script>

<style scoped>

</style>
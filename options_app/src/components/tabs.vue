<template>
  <el-tabs>
    <el-tab-pane
      v-for="(tab, i) in tabs"
      :key="i"
      :label="tab.properties.name"
      :name="i.toString()">
      <component-builder :nodes="tab.children"></component-builder>
    </el-tab-pane>
  </el-tabs>
</template>

<script>
export default {
  name: "vue-tabs",
  props: ["node"],
  computed: {
    tabs() {
      return this.node.children.filter((node) => node.type === "tab");
    }
  }
}
</script>

<style scoped>

</style>
<template>
  <el-alert
      class="form-notice"
      :title="node.properties.title"
      :type="node.properties.type"
      :description="node.properties.text"
      show-icon>
  </el-alert>
</template>

<script>
export default {
  name: "vue-notice",
  props: ["node"],
}
</script>

<style scoped>
</style>
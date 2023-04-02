<template>
  <el-divider content-position="left">{{ node.properties.title }}</el-divider>
</template>

<script>
export default {
  name: "vue-divider",
  props: ["node"],
}
</script>

<style scoped>
.el-divider--horizontal{
  margin: 40px 0;
}
</style>
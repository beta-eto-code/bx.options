<template>
  <el-form-item :error="errorMessage" :label="node.label">
    <el-input v-model="value"></el-input>
  </el-form-item>
</template>

<script>
import BaseFormField from "@/BaseFormField";
export default {
  mixins: [BaseFormField],
  name: "text-field",
  props: ["node"],
}
</script>

<style scoped>

</style>
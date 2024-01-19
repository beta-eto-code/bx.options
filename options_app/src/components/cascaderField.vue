<template>
  <el-cascader
    class="form-cascader"
    v-model="value"
    :options="node.properties.options"
    :props="{
      multiple: node.properties.multiple
    }"
    :collapse-tags="node.properties.collapseTags"
    >
    </el-cascader>
</template>

<script>
import BaseFormField from "@/BaseFormField";
export default {
  mixins: [BaseFormField],
  name: "cascader-field",
  props: ["node"],
}
</script>

<style scoped>
.form-cascader {
  padding-top: 20px;
  padding-bottom: 20px;
}
</style>

<template>
  <el-form-item :label="node.label">
    <el-select
        v-model="value"
        filterable
        placeholder="Выбор"
        :multiple="node.properties.multiple"
    >
      <el-option
        v-for="(label, value) in node.properties.options"
        :key="value"
        :label="label"
        :value="value">
      </el-option>
    </el-select>
  </el-form-item>
</template>

<script>
import BaseFormField from "@/BaseFormField";
export default {
  mixins: [BaseFormField],
  name: "select-field",
  props: ["node"],
}
</script>

<style scoped>

</style>
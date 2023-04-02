<template>
  <div>
    <component
      v-for="(node, i) in nodes"
      :is="getComponentByType(node.type)"
      :key="i"
      :node="node"
    >
    </component>
  </div>
</template>

<script>
import VueTabs from "@/components/tabs";
import VueTab from "@/components/tab";
import TextField  from "@/components/text-field";
import SelectField from "@/components/selectField";
import VueDivider from "@/components/divider";
import VueNotice from "@/components/notice";
export default {
  name: "component-builder",
  props: {
    nodes: {
      type: Array,
      default: () => []
    }
  },
  data(){
    return {
      registerComponent: {
        "tabs": VueTabs,
        "tab": VueTab,
        "text_field": TextField,
        "select_field": SelectField,
        "divider": VueDivider,
        "notice": VueNotice,
      }
    }
  },
  components: {
    VueTabs, VueTab, TextField, SelectField, VueDivider, VueNotice
  },
  methods: {
    getComponentByType(type){
      let component = this.registerComponent[type];
      if (component) {
        return component.name;
      }
      console.log("Component not found: " + type)
      return "";
    }
  }
}
</script>

<style scoped>

</style>
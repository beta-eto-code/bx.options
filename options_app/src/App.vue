<template>
  <div id="app">
    <el-card v-loading="loading">
      <el-form ref="form" :model="form" label-width="120px">
        <component-builder :nodes="nodes"></component-builder>
        <el-button type="primary" @click="onSubmit">Сохранить</el-button>
      </el-form>
    </el-card>
  </div>
</template>

<script>
import ComponentBuilder from "@/component-builder";
import axios from "axios";

export default {
  name: 'App',
  props: ["optionsConfig"],
  data(){
    return {
      config:{},
      form:{},
      error:[],
      loading: false
    }
  },
  computed: {
    nodes(){
      if(this.config.children){
        return this.setErrorOnNode(this.config.children);
      }
      return [];
    }
  },
  methods: {
    setErrorOnNode(nodes){
      return nodes.map(node => {
        let newNode = Object.assign({}, node);
        let nodeError = this.error.find((error) => {
          return error.field === node.name;
        });

        if (nodeError) {
          newNode.error = true;
          newNode.errorMessage = nodeError.error;
        }

        if (node.children && node.children.length > 0) { // добавлено условие node.children
          newNode.children = this.setErrorOnNode(node.children)
        }

        return newNode;
      });
    },
    onSubmit(){
      this.error = [];
      this.loading = true;
      axios.post(this.config.properties.action, this.form).then(() => {
        console.log(this.form);
        this.$notify.success({
          title: 'Сохранено',
          message: 'Настройки успешно сохранены',
          showClose: false
        });
      }).catch((error) => {
        if(error.response.status === 400){
          this.error = error.response.data.errors;
        }
        this.$notify.error({
          title: 'Ошибка',
          message: 'Не удалось сохранить настройки',
          showClose: false
        });
      }).finally(() => {
        this.loading = false;
      });
    }
  },
  components: {
    ComponentBuilder
  },
  mounted(){
    this.config = this.optionsConfig;
    this.$root.$on("change", (data) => {
      this.form[data.name] = data.value;
    });

    // fix bitrix styles
    const elements = document.querySelectorAll(".adm-workarea");
    elements.forEach((element) => {
      element.classList.remove("adm-workarea");
      element.style.padding = "20px 20px";
    });
  }
}
</script>

<style scoped>
#app {
    font-family: Avenir, Helvetica, Arial, sans-serif;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    color: #2c3e50;
    margin-top: 10px;
    max-width: 100%;
}
.btn__save {
    margin-top: 15px;
}
</style>


export default  {
    data:  function () {
        return {
            value:  "" ,
            name:  "" ,
        }
    },
    watch:{
        value:  function (val) {
            this.$root.$emit('change' , {name: this.name, value: val});
        }
    },
    computed:{
        errorMessage: function () {
            return this.node.errorMessage ? this.node.errorMessage : "";
        },
    },
    mounted() {
        this.name = this.node.name;
        this.value = this.node.value;
    }
}
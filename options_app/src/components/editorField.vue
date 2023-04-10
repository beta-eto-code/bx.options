<template>
    <el-form-item :error="errorMessage" :label="node.label">
        <vue-editor
                placeholder="Введите текст"
                :editorOptions="editorSettings"
                v-model="value"
        ></vue-editor>
    </el-form-item>
</template>

<script>
import BaseFormField from "@/BaseFormField";

export default {
    mixins: [BaseFormField],
    name: "editor-field",
    props: ["node"],


    data() {
        return {
            editorSettings: {
                modules: {
                    toolbar: [
                        ["bold", "italic"],
                    ],
                }
            }
        }
    }

}
</script>

<style>
.ql-toolbar.ql-snow, .ql-container.ql-snow {
    border: none !important;
}

.quillWrapper {
    border-radius: 4px;
    border: 1px solid #dcdfe6;
}

.el-form-item.is-error .quillWrapper {
    border-color: #f56c6c;
}

</style>

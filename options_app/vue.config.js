const path = require('path')
const { defineConfig } = require('@vue/cli-service')
const Dotenv = require('dotenv-webpack');

console.log('ENV', process.env);
module.exports = defineConfig({
    transpileDependencies: true,
    outputDir: process.env.NODE_ENV === 'production'
        ? '../install/components/bx.options/option.form/templates/vue_app/'
        : '../../components/bx.options/option.form/templates/vue_app/'
    ,
    configureWebpack:{
        optimization: {
            splitChunks: false
        },
        output: {
            filename: "script.js",
        },
        plugins: [
            new Dotenv()
        ],
    },
    css:{
        extract: {
            filename: "style.css",
        }
    },
    devServer: {
        proxy: {
            '/api': {
                target: 'http://localhost',
                pathRewrite: {'^/api': ''},
                changeOrigin: true
            }
        }
    },
    chainWebpack: config => {
        config.optimization.delete('splitChunks')
    }
})

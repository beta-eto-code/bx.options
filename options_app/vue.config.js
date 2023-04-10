const path = require('path')
const { defineConfig } = require('@vue/cli-service')
const Dotenv = require('dotenv-webpack');
const getAssetPath = require("@vue/cli-service/lib/util/getAssetPath");

const genAssetSubPath = dir => {
    return getAssetPath(
        process.env,
        `${dir}/[name]${process.env.filenameHashing ? '.[hash:8]' : ''}[ext]`
    )
}

const publicPath = process.env.NODE_ENV === 'production' ? '/local/components/bx.options/option.form/templates/vue_app/' : '';

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
        config.optimization.delete('splitChunks');
        config.module
            .rule('fonts')
            .test(/\.(woff2?|eot|ttf|otf)(\?.*)?$/i)
            .set('type', 'asset')
            .set('generator', {
                filename: genAssetSubPath('fonts'),
                publicPath: publicPath,
            });
    }
})

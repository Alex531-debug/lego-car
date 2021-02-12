const path = require('path')
const VueLoaderPlugin = require('vue-loader/lib/plugin');

module.exports = {
  watch: true, // перегенерация файлов при изменении
  entry: {
  	//vendor: './src/vendor.js',
    wl: 'webpack-dev-server/client?http://statcart:3000',
    wh: 'webpack/hot/only-dev-server',
  	main: './public/static/vue/main.js'
  },
  module: {
    rules: [
      { test: /\.svg$/, use: 'svg-inline-loader' },
      { test: /\.css$/i, use: [ 'vue-style-loader', 'style-loader', 'css-loader' ]},
      { test: /\.(js)$/, use: 'babel-loader' },
      { test: /\.vue$/, use: 'vue-loader' },
      { test: /\.ts$/, use: 'ts-loader' }
    ]
  },
  output: {
    path: path.resolve(__dirname, 'public/dist'),
    filename: '[name].bundle.js' //'[name].[contenthash].bundle.js'
  },
  devServer: {
    contentBase: path.join(__dirname, 'public/dist'),
    compress: false,
    port: 8080
  },
  plugins: [
      new VueLoaderPlugin()
  ],
  resolve: {
    alias: {
      vue$: 'vue/dist/vue.esm.js'
    }
  },
  mode: process.env.NODE_ENV === 'production' ? 'production' : 'development'
}
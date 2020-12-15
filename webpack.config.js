/* eslint-disable */
// Require path.
const path = require('path')
const MinifyPlugin = require('babel-minify-webpack-plugin')

// Configuration object.
const config = {

  // Create the entry points.
  entry: {
    // Individual entry points are here
    scripts: './assets/js/scripts.js'
  },

  // Create the output files.
  // One for each of our entry points.
  output: {
    // [name] allows for the entry object keys to be used as file names.
    filename: 'js/[name].min.js',
    // Specify the path to the JS files.
    path: path.resolve(__dirname, 'dist')
  },

  // Setup a loader to transpile down the latest and great JavaScript so older browsers
  // can understand it.
  module: {
    rules: [
      {
        // Look for any .js files.
        test: /\.js$/,
        // Exclude the node_modules folder.
        exclude: /node_modules/,
        // Use babel loader to transpile the JS files.
        loader: 'babel-loader',
        options: {
          presets: ['@babel/preset-env']
        }
      }
    ]
  },
  plugins: [
    new MinifyPlugin()
  ]
}

// Export the config object.
module.exports = (env, argv) => {
  if (argv.mode === 'development') {
    config.devtool = 'source-map'
  }

  return config
}

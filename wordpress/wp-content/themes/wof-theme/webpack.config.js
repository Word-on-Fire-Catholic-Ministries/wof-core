// Require path.
const path = require( 'path' );
const MinifyPlugin = require('babel-minify-webpack-plugin');

// Configuration object.
const config = {
    devtool: "source-map",
    // Create the entry points.
    // One for frontend and one for the admin area.
    entry: {
        // frontend and admin will replace the [name] portion of the output config below.
        'front': './assets/js/front.js',
        'admin': './assets/js/admin.js',
        'latest-content': './assets/js/blocks/latest-content.js'
    },

    // Create the output files.
    // One for each of our entry points.
    output: {
        // [name] allows for the entry object keys to be used as file names.
        filename: 'js/[name].min.js',
        // Specify the path to the JS files.
        path: path.resolve( __dirname, 'dist' )
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
module.exports = config;
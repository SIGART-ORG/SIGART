'use strict';

const Path = require('path');
const Webpack = require('webpack');
const HtmlWebpackPlugin = require('html-webpack-plugin');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CleanWebpackPlugin = require('clean-webpack-plugin');
const ExtractSASS = new ExtractTextPlugin('./[name].css');
const CopyWebpackPlugin = require('copy-webpack-plugin');
const BrowserSyncPlugin = require('browser-sync-webpack-plugin');
const webpack = require('webpack');
const VueLoaderPlugin = require('vue-loader/lib/plugin')

module.exports = (options) => {
    const dest = Path.join(__dirname, 'public/notification');
    console.log(options.devtool)
    let webpackConfig = {
        devtool: options.devtool,
        //devtool:false,
        mode: options.isProduction ? 'production' : 'development',
        output: {
            path: dest,
            //filename: './js/[name].[hash].js'
            filename: './js/[name].js'
        },
        plugins: [
            new Webpack.ProvidePlugin({
                $: 'jquery',
                jQuery: 'jquery',
                'window.jQuery': 'jquery',
                Tether: 'tether',
                'window.Tether': 'tether',
                Popper: ['popper.js', 'default'],
            }),
            // new CopyWebpackPlugin([
            //     {from: './resources/theme/assets/images', to: './assets/images'}
            // ]),
            // new CopyWebpackPlugin([
            //     {from: './resources/theme/assets/fonts', to: './assets/fonts'}
            // ]),
            new Webpack.DefinePlugin({
                'process.env': {
                    NODE_ENV: JSON.stringify(options.isProduction ? 'production' : 'development')
                }
            }),
            new VueLoaderPlugin()
        ],
        resolve:{
            alias: {
                'vue': 'vue/dist/vue.js'
            },
        },
        module: {
            rules: [
                {
                    test: /\.js$/,
                    exclude: /node_modules/,
                    loader: 'babel-loader'
                },
                {
                    test: /\.hbs$/,
                    loader: 'handlebars-loader',
                    query: {
                        helperDirs: [
                            Path.join(__dirname, 'src', 'helpers')
                        ],
                        partialDirs: [
                            Path.join(__dirname, 'src', 'layout'),
                            Path.join(__dirname, 'src', 'DemoPages'),
                        ]
                    }
                },
                {
                    test: /\.(woff(2)?|ttf|eot|svg)(\?v=\d+\.\d+\.\d+)?$/,
                    use: [{
                        loader: 'file-loader',
                        options: {
                            name: '[name].[ext]',
                            outputPath: './assets/fonts'
                        }
                    }]
                },
                {
                    test: /\.(gif|jpg|png)$/,
                    loader: 'file-loader',
                    options: {
                        name: '[name].[ext]',
                        outputPath: './assets/images'
                    }
                }
            ]
        }
    };

    if (options.isProduction) {


    } else {

    }

    webpackConfig.entry = [
        './resources/notification/app.js',
    ];

    webpackConfig.plugins.push(
        ExtractSASS,
        new CleanWebpackPlugin([dest], {
            verbose: true,
            dry: false
        })
    );

    webpackConfig.module.rules.push({
        test: /\.scss$/i,
        use: ExtractSASS.extract(['css-loader', 'sass-loader'])
    }, {
        test: /\.css$/i,
        use: ExtractSASS.extract(['css-loader'])
    }, {
        test: /\.vue$/i,
        loader: 'vue-loader'
    });

    //webpackConfig.plugins = webpackConfig.plugins.concat(renderedPages);


    return webpackConfig;

};

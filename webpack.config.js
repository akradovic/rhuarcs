const path = require('path');
const TerserPlugin = require('terser-webpack-plugin');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

module.exports = (env, argv) => {
    const isProduction = argv.mode === 'production';

    return {
        entry: {
            admin: './assets/js/admin/src/index.js',
            frontend: './assets/js/src/index.js'
        },
        output: {
            path: path.resolve(__dirname, 'assets/js/build'),
            filename: '[name].[contenthash].js',
            clean: true
        },
        module: {
            rules: [
                {
                    test: /\.(js|jsx)$/,
                    exclude: /node_modules/,
                    use: {
                        loader: 'babel-loader',
                        options: {
                            presets: ['@babel/preset-env', '@babel/preset-react'],
                            plugins: [
                                '@babel/plugin-transform-runtime',
                                isProduction && 'transform-react-remove-prop-types'
                            ].filter(Boolean)
                        }
                    }
                },
                {
                    test: /\.css$/,
                    use: [
                        isProduction ? MiniCssExtractPlugin.loader : 'style-loader',
                        'css-loader',
                        'postcss-loader'
                    ]
                },
                {
                    test: /\.(png|svg|jpg|jpeg|gif)$/i,
                    type: 'asset/resource',
                    generator: {
                        filename: 'images/[hash][ext][query]'
                    }
                }
            ]
        },
        optimization: {
            minimize: isProduction,
            minimizer: [
                new TerserPlugin({
                    terserOptions: {
                        format: {
                            comments: false,
                        },
                        compress: {
                            drop_console: true
                        }
                    },
                    extractComments: false
                }),
                new CssMinimizerPlugin()
            ],
            splitChunks: {
                chunks: 'all',
                cacheGroups: {
                    vendor: {
                        test: /[\\/]node_modules[\\/]/,
                        name: 'vendors',
                        chunks: 'all'
                    }
                }
            }
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: isProduction ? 'css/[name].[contenthash].css' : 'css/[name].css'
            })
        ],
        resolve: {
            extensions: ['.js', '.jsx'],
            alias: {
                '@': path.resolve(__dirname, 'assets/js/src'),
                '@admin': path.resolve(__dirname, 'assets/js/admin/src')
            }
        },
        devtool: isProduction ? 'source-map' : 'eval-source-map',
        externals: {
            react: 'React',
            'react-dom': 'ReactDOM'
        },
        performance: {
            hints: isProduction ? 'warning' : false,
            maxEntrypointSize: 512000,
            maxAssetSize: 512000
        }
    };
};
// webpack.config.js
const path = require('path');

module.exports = {
    entry: './assets/js/admin/src/index.js',
    output: {
        path: path.resolve(__dirname, 'assets/js/admin/build'),
        filename: 'index.js',
    },
    module: {
        rules: [
            {
                test: /\.(js|jsx)$/,
                exclude: /node_modules/,
                use: {
                    loader: 'babel-loader',
                    options: {
                        presets: ['@babel/preset-env', '@babel/preset-react']
                    }
                }
            },
            {
                test: /\.css$/,
                use: ['style-loader', 'css-loader', 'postcss-loader']
            }
        ]
    },
    externals: {
        react: 'React',
        'react-dom': 'ReactDOM'
    }
};
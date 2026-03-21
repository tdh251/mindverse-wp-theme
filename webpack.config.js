const path = require('path');
const MiniCssExtractPlugin = require('mini-css-extract-plugin');
const CssMinimizerPlugin = require('css-minimizer-webpack-plugin');

module.exports = (env, argv) => {
    const isProduction = argv.mode === 'production';

    return {
        entry: {
            style: path.resolve(__dirname, 'assets/scss/style.scss'),
        },
        output: {
            path: path.resolve(__dirname, 'assets'),
            filename: 'scss/.temp/[name].js', 
            clean: false, 
        },
        module: {
            rules: [
                {
                    test: /\.scss$/,
                    use: [
                        MiniCssExtractPlugin.loader,
                        'css-loader',
                        'postcss-loader',
                        {
                            loader: 'sass-loader',
                            options: {
                                sassOptions: { quietDeps: true, }
                            }
                        }
                    ],
                },
            ],
        },
        plugins: [
            new MiniCssExtractPlugin({
                filename: 'css/[name].min.css', 
            }),
        ],
        optimization: {
            minimize: isProduction,
            minimizer: [
                new CssMinimizerPlugin(),
            ],
        },
        mode: isProduction ? 'production' : 'development',
        devtool: isProduction ? false : 'source-map',
        watch: !isProduction,
        stats: 'errors-warnings',
    };
};
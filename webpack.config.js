const path = require( 'path' );
const autoprefixer = require( 'autoprefixer' );
const MiniCssExtractPlugin = require( 'mini-css-extract-plugin' );
const OptimizeCssAssetsPlugin = require( 'optimize-css-assets-webpack-plugin' );
const TerserPlugin = require( 'terser-webpack-plugin' );
const { CleanWebpackPlugin } = require( 'clean-webpack-plugin' );
const webpack = require('webpack');

module.exports = ( env, argv ) => {
	function isDevelopment() {
		return 'development' === argv.mode;
	}

	var config = {
		entry: {
			listing: './assets/js/index.js',
		},
		output: {
			path: path.resolve( __dirname, 'build' ),
			filename: '[name].js'
		},
		devtool: isDevelopment() ? 'cheap-module-source-map' : 'source-map',
		optimization: {
			minimizer: [
				new TerserPlugin(),
				new OptimizeCssAssetsPlugin({
					cssProcessorOptions: {
						map: {
							inline: false,
							annotation: true
						}
					}
				})
			]
		},
		plugins: [
			new CleanWebpackPlugin(),
			new MiniCssExtractPlugin({
				chunkFilename: '[id].css',
				filename: ( chunkData ) => {
					return chunkData.chunk.name === 'script' ? 'style.css' : '[name].css';
				}
			}),
			new webpack.ProvidePlugin({
				process: 'process/browser',
			})
		],
		module: {
			rules: [
				{
					test: /\.js$/,
					exclude: /node_modules/,
					use: {
						loader: 'babel-loader',
						options: {
							presets: [
								'@babel/preset-env',
								[
									'@babel/preset-react',
									{
										"pragma": "wp.element.createElement",
										"pragmaFrag": "wp.element.Fragment",
										"development": isDevelopment()
									}
								]
							]
						}
					}
				},
				{
					test: /\.(sa|sc|c)ss$/,
					use: [
						MiniCssExtractPlugin.loader,
						'css-loader',
						{
							loader: 'postcss-loader',
							options: {
								postcssOptions: {
									plugins: [
										autoprefixer()
									]
								}
							}
						},
						'sass-loader'
					]
				}
			]
		},
		externals: {
			"@wordpress/element": [ "wp", "element" ], // wp.block
			"@wordpress/i18n": [ "wp", 'i18n' ],  // wp.i18n
			"@wordpress/dom-ready": [ "wp", 'domReady' ],
			"@wordpress/api-fetch": [ "wp", 'apiFetch' ],
			"@wordpress/compose": [ "wp", 'compose' ]
		},

		resolve: {
			alias: {
				jsPath: path.resolve( __dirname, 'assets/js' ),
			},
		},

	}

	return config;
};

const config = require('flarum-webpack-config');

const webpackConfig = config();

// Disable source maps to avoid sycho/sourcemap PHP 8.x compatibility issues
webpackConfig.devtool = false;

module.exports = webpackConfig;

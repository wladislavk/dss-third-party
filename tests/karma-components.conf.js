const baseConfig = require('./karma.conf')
const webpackConfig = require('../build/webpack.test.conf')
delete webpackConfig.entry
const filename = 'index-components.js'

module.exports = function (config) {
  const configParams = baseConfig(filename, webpackConfig)
  config.set(configParams)
}

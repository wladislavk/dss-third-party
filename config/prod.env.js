const merge = require('webpack-merge')
const processEnv = process.env

module.exports = merge(processEnv, {
  NODE_ENV: '"production"',
  HEADLESS_API_ROOT: '"http://api/"',
  HEADLESS_API_PATH: '"http://api/api/v1/"',
  HEADLESS_LEGACY_ROOT: '"http://loader/"'
})

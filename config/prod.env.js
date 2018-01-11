const merge = require('webpack-merge')
const processEnv = process.env

module.exports = merge(processEnv, {
  NODE_ENV: '"production"',
  STATIC_ROOT: '"https://static.docker.localhost/"',
  HEADLESS_API_ROOT: '"http://api/"',
  HEADLESS_API_PATH: '"http://api/api/v1/"',
  HEADLESS_LEGACY_ROOT: '"http://loader/"',
  HEADLESS_STATIC_ROOT: '"http://static/"',
  FILE_STORAGE: '"legacy"'
})

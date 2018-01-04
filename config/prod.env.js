const merge = require('webpack-merge')
const processEnv = process.env

module.exports = merge(processEnv, {
  NODE_ENV: '"production"'
})

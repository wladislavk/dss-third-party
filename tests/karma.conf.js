const webpackConfig = require('../build/webpack.test.conf')
delete webpackConfig.entry

module.exports = function (config) {
  config.set({
    browsers: ['ChromeNoSandboxHeadless'],
    browserConsoleLogOptions: {
      level: 'log',
      format: '%b %T: %m',
      terminal: true
    },
    captureConsole: true,
    frameworks: ['jasmine'],
    // this is the entry file for all our tests.
    files: ['index.js'],
    // we will pass the entry file to webpack for bundling.
    preprocessors: {
      './index.js': ['webpack']
    },
    // use the webpack config
    webpack: webpackConfig,
    // avoid walls of useless text
    webpackMiddleware: {
      noInfo: true
    },
    singleRun: true,

    customLaunchers: {
      ChromeNoSandboxHeadless: {
        base: 'Chromium',
        flags: [
          '--no-sandbox',
          // See https://chromium.googlesource.com/chromium/src/+/lkgr/headless/README.md
          '--headless',
          '--disable-gpu',
          // Without a remote debugging port, Google Chrome exits immediately.
          ' --remote-debugging-port=9222'
        ]
      }
    }
  })
}

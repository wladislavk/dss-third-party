module.exports = function (filename, webpackConfig) {
  return {
    browsers: ['ChromeNoSandboxHeadless'],
    browserConsoleLogOptions: {
      level: 'log',
      format: '%b %T: %m',
      terminal: true
    },
    captureConsole: true,
    frameworks: ['jasmine'],
    // this is the entry file for all our tests.
    files: [filename],
    // we will pass the entry file to webpack for bundling.
    preprocessors: {
      './index-unit.js': ['webpack'],
      './index-components.js': ['webpack']
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
  }
}

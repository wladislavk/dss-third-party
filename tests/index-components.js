const testsContext = require.context('./components', true, /\.spec$/)
testsContext.keys().forEach(testsContext)

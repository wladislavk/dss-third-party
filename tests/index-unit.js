const testsContext = require.context('./unit', true, /\.spec$/)
testsContext.keys().forEach(testsContext)

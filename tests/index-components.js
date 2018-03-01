const testsContext = require.context('./components', true, /EdxCertificate\.spec$/)
testsContext.keys().forEach(testsContext)

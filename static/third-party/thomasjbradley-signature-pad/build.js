#!/usr/bin/env node

/*
 * Module dependencies
 */
var fs = require('fs')
var exec = require('child_process').exec
var jshint = require('jshint').JSHINT

var jshintrc = JSON.parse(fs.readFileSync('.jshintrc', 'utf8'))
var sigPadPath = 'jquery.signaturepad.js'
var sigPadMinPath = 'build/jquery.signaturepad.min.js'
var source = fs.readFileSync(sigPadPath, 'utf8')
var valid = jshint(source, jshintrc)

process.stdout.write('JSHinting... ')

if (valid) {
  process.stdout.write('done.\nMinifying... ')

  exec('java -jar ~/bin/compiler.jar --js ' + sigPadPath + ' --js_output_file ' + sigPadMinPath,
    function (err, stdout, stderr) {
      var sp = fs.readFileSync(sigPadMinPath, 'utf8')
      var ver = fs.readFileSync('VERSION.txt', 'utf8')
      var spVer = sp.replace(/{{version}}/, ver.trim())

      fs.writeFileSync(sigPadMinPath, spVer)

      process.stdout.write('done.\n')
    }
  )
} else {
  var e = null

  console.log('\nJSHint failed with errors:')

  for (var i = 0, t = jshint.errors.length; i < t; i++) {
    e = jshint.errors[i]
    console.log('• Line: ' + e.line + ' Col: ' + e.character + '; ' + e.reason)
  }

  console.log('Build incomplete.')
}

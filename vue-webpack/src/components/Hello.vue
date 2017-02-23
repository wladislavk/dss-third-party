<template>
  <div class="hello">
    <h1>{{ msg }}</h1>
    <form class="sigPad" style="margin-left:20px">
        <p class="typeItDesc">Review your signature</p>
        <p class="drawItDesc">Draw your signature</p>
        <ul class="sigNav">
            <li class="clearButton">
                <a href="#clear">Clear</a>
            </li>
        </ul>
        <div class="sig sigWrapper">
            <div class="typed"></div>
            <canvas class="pad" width="198" height="55"></canvas>
            <input type="hidden" name="output" class="output">
        </div>
        <button
            v-on:click.prevent="test"
            name="sign_but"
        >Save Signature</button>
        <button
            v-if="false"
            onclick="$('#update_signature').hide();return false;"
        >Cancel</button>
    </form>
  </div>
</template>

<script>

var $ = require('jquery/dist/jquery.min.js')
window.jQuery = $

require('../../static/third-party/thomasjbradley-signature-pad/build/jquery.signaturepad.min.js')
import '../../static/third-party/thomasjbradley-signature-pad/build/json2.min.js'

import '../../static/third-party/thomasjbradley-signature-pad/build/jquery.signaturepad.css'

export default {
  name: 'hello',
  data () {
    return {
      msg: 'Welcome to Your Vue.js App'
    }
  },
  mounted () {
    $('.sigPad').signaturePad({drawOnly: true})
  },
  methods: {
    test: function () {
      console.log($('.sigPad'))
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
h1, h2 {
  font-weight: normal;
}

ul {
  list-style-type: none;
  padding: 0;
}

li {
  display: inline-block;
  margin: 0 10px;
}

a {
  color: #42b983;
}
</style>

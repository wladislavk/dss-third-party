import $ from 'jquery'

export default {
  screenerDoctor: () => {
    $("a[rel='fancyReg']").fancybox({
      'transitionIn': 'elastic',
      'width': 300,
      'height': 150,
      'autoDimensions': false,
      'overlayOpacity': '0',
      'hideOnOverlayClick': false
    })
  }
}

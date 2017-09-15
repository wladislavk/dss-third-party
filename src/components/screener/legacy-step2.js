import $ from 'jquery'

export default function (e) {
  e.preventDefault()

  const nextSection = getNext(2)

  nextSection.section.hide()
  nextSection.sectionDis.show()

  let returnVal = true
  let errorText = ''
  const epworthProps = []

  for (let epworth of epworthProps) {
    let epworthDiv = $('#epworth_' + epworth.id + '_div')
    if (epworthDiv.find('select').val() === '') {
      epworthDiv.addClass('error')
      errorText += '<label for="epworth_' + epworth.id + '" data-generated="true" class="error" style=""><strong>' + epworth.name + '</strong>: Please provide an answer</label>'
      returnVal = false
    } else {
      epworthDiv.removeClass('error')
    }
  }
  if (returnVal) {
    nextSect(3)
  } else {
    nextSection.section.show()
    nextSection.sectionDis.hide()
    $('#epworth_error_box').html(errorText).show()
  }
}

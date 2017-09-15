import $ from 'jquery'
import symptoms from './legacy-symptoms'

export default function (e) {
  e.preventDefault()

  const nextSection = getNext(3)

  nextSection.section.hide()
  nextSection.sectionDis.show()

  let returnVal = true
  let errorText = ''

  for (let symptom of symptoms) {
    let symptomDiv = $('#' + symptom.name + '_div')

    if (symptomDiv.find('input:checked').val() === null) {
      symptomDiv.addClass('error')
      errorText += '<label for="' + symptom.name + '" data-generated="true" class="error" style=""><strong>' + symptom.label + '</strong>: Please provide an answer</label>'
      returnVal = false
    } else {
      symptomDiv.removeClass('error')
    }
  }

  if (returnVal) {
    nextSect(4)
  } else {
    nextSection.section.show()
    nextSection.sectionDis.hide()
    $('#sect3_error_box').html(errorText).show()
  }
}

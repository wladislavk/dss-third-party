import $ from 'jquery'
import coMorbidityData from './legacy-comorbidity'
import symptoms from './legacy-symptoms'

export default function (e) {
  e.preventDefault()

  const nextSection = getNext(4)

  nextSection.section.hide()
  nextSection.sectionDis.show()

  function onFailure () {
    nextSection.section.show()
    nextSection.section.hide()
    alert('There was an error communicating with the server, please try again in a few minutes')
  }

  const firstNameField = $('#first_name')
  const lastNameField = $('#last_name')
  const phoneField = $('#phone')

  for (let symptom of symptoms) {
    symptom.selector = $('input[name=' + symptom.name + ']:checked')
  }

  const epworthProps = []

  const screenerData = {
    docid: $('#docid').val(),
    userid: $('#userid').val(),
    first_name: firstNameField.val(),
    last_name: lastNameField.val(),
    phone: phoneField.val()
  }

  for (let epworth of epworthProps) {
    const propertyName = 'epworth_' + epworth.id
    screenerData[propertyName] = $('#' + propertyName).val()
  }

  for (let symptom of symptoms) {
    screenerData[symptom.name] = symptom.selector.val()
  }

  for (let i = 1; i <= 5; i++) {
    let propertyName = 'snore_' + i
    screenerData[propertyName] = $('#' + propertyName).val()
  }

  /**
   * Include the co-morbidity fields, based on the weight list.
   *
   * All these fields are checkboxes
   */
  for (let coMorbidity of coMorbidityData) {
    screenerData[coMorbidity.name] = 0
    if (+$('input[name="' + coMorbidity.name + '"]:checked').val()) {
      screenerData[coMorbidity.name] = coMorbidity.weight
    }
  }

  $.ajax({
    url: 'script/submit_screener.php',
    type: 'post',
    data: screenerData,
    success: function (data) {
      const r = $.parseJSON(data)

      if (r.error) {
        onFailure()
        return
      }

      screenerId = r.screenerid

      // update view results div
      $('#r_first_name').text(firstNameField.val())
      $('#r_last_name').text(lastNameField.val())
      $('#r_phone').text(phoneField.val())

      const epworthProps = []
      for (let epworth of epworthProps) {
        $('#r_epworth_' + epworth.id).text($('#epworth_' + epworth.id).val())
      }

      for (let symptom of symptoms) {
        let inputVal = 'No'
        if (symptom.selector.val() > 0) {
          inputVal = 'Yes'
        }
        $('#r_' + symptom.name).text(inputVal)
      }

      $('#r_rx_cpap').text(($('input[name=rx_cpap]:checked').val() > 0) ? 'Yes' : 'No')

      const diagnosed = $('#r_diagnosed')
      for (let coMorbidity of coMorbidityData) {
        const inputValue = +$('input[name="' + coMorbidity.name + '"]:checked').val()
        if (coMorbidity.label && inputValue) {
          diagnosed.append('<li>' + coMorbidity.label + '</li>')
        }
      }

      const resultsDivCheck = $('#results_div').find('div.check')
      resultsDivCheck.each(function () {
        const result = $(this).find('span').text()

        switch (result) {
          case '':
          // fall through
          case 'No':
          // fall through
          case 0:
            $(this).hide()
            break
          case 1:
            $(this).find('span').text('1 - Slight chance of dozing')
            break
          case 2:
            $(this).find('span').text('2 - Moderate chance of dozing')
            break
          case 3:
            $(this).find('span').text('3 - High chance of dozing')
            break
        }
      })

      let ep = 0
      for (let epworth of epworthProps) {
        ep += parseInt($('#epworth_' + epworth.id).val(), 10)
      }

      $('#r_ep_total').text(ep)

      /**
       * Sum the co-morbidity fields, based on the weight list.
       *
       * All these fields are checkboxes
       */
      let sect3 = 0

      for (let coMorbidity of coMorbidityData) {
        if (+$('input[name="' + coMorbidity.name + '"]:checked').val()) {
          sect3 += coMorbidity.weight
        }
      }

      let survey = 0

      for (let symptom of symptoms) {
        if (symptom.selector.val()) {
          survey += parseInt(symptom.selector.val(), 10)
        }
      }

      $('.risk_desc').hide()

      let riskLevel = _calculateRisk(survey, ep, sect3)
      const img = 'images/screener-' + riskLevel + '_risk.png'
      $('#risk_' + riskLevel).show()

      const patientName = $('.pat_name')
      const riskImage = $('#risk_image')
      const riskImageDoc = $('#risk_image_doc')

      const imageSource = '<img src="' + img + '" />'

      patientName.text(firstNameField.val())
      riskImage.html(imageSource)
      riskImageDoc.html(imageSource)

      _updateHstDiv()

      nextSect('results')
    },
    error: onFailure
  })
}

function _calculateRisk (survey, ep, sect3) {
  if (survey > 15 || ep > 18 || sect3 > 3) {
    return 'severe'
  }
  if (survey > 11 || ep > 14 || sect3 > 2) {
    return 'high'
  }
  if (survey > 7 || ep > 9 || sect3 > 1) {
    return 'moderate'
  }
  return 'low'
}

function _updateHstDiv () {
  $('#hst_first_name').val($('#first_name').val())
  $('#hst_last_name').val($('#last_name').val())
  $('#hst_phone').val($('#phone').val())
}

import $ from 'jquery'

$(function () {
  /**
   * Ugly hack from http://stackoverflow.com/a/2196683
   */
  $.expr[':'].icontains = $.expr.createPseudo(function (arg) {
    return function (elem) {
      return $(elem).text().toUpperCase().indexOf(arg.toUpperCase()) >= 0
    }
  })

  /**
   * Add breadcrumb
   */
  const $container = $('<div class="row hidden-print" style="text-transform: capitalize;">' +
          '<div class="col-md-12">' +
              '<h3 class="page-title"></h3>' +
              '<ul class="page-breadcrumb breadcrumb">' +
                  '<li>' +
                      '<i class="fa fa-home"></i>' +
                      '<a href="/manage/admin/home.php">Home</a>' +
                      '<i class="fa fa-angle-right"></i>' +
                  '</li>' +
              '</ul>' +
          '</div>' +
      '</div>')
  const $breadcrumb = $container.find('ul')
  let path = window.location.href.replace(/^.+?\/([^/]+)$/, '$1')

  if (path.indexOf('?') >= 0) {
    path = path.substr(0, path.indexOf('?'))
  }

  $('.page-sidebar-menu').find('li a[href*="' + path + '"]').parents('li').find('>a:nth-child(1)').each(function () {
    const $this = $(this)
    const $source = $this.find('span.title')
    const text = ($source.length ? $source : $this).text().trim().toLowerCase()

    if ($this.is('[href$="#"], [href^="javascript"]')) {
      $breadcrumb.append('<li><span/><i class="fa fa-angle-right"></i></li>')
        .find('span:last')
        .text(text)
    } else {
      $breadcrumb.append('<li><a/><i class="fa fa-angle-right"></i></li>')
        .find('a:last')
        .text(text)
        .attr('href', this.href)
    }
  })

  // Convert the last breadcrumb link into a text node, and set the title
  $breadcrumb.find('li:last').each(function () {
    const $this = $(this)
    $this.text($this.text())
    $container.find('.page-title').append($this.text())
  })

  $container.insertAfter('.row1')

  /**
   * Popup
   */
  $('[onclick*=loadPopup]')
    .each(function () {
      const $this = $(this)
      const legend = $this.text().trim()
      const click = $this.attr('onclick')
      const popup = click.replace(/(javascript: *)?loadPopup\(['"](.+?)['"]\).*/i, '$2')

      $this.removeAttr('onclick')
      $this.data('legend', legend)
      $this.data('popup', popup)
    })
    .off('click')
    .on('click', function (e) {
      e.preventDefault()

      const $this = $(this)
      const legend = $this.data('legend')
      const popup = $this.data('popup')
      const modal = $('#popup-window')
      const iframe = modal.find('iframe')

      iframe.attr('src', popup)
      modal.find('.modal-title').text(legend)
      modal.modal('show')

      return false
    })

  const datepickerCalendar = $('.datepicker, .calendar')

  /**
   * Datepicker
   */
  if (typeof $.fn.datepicker !== 'undefined') {
    datepickerCalendar.datepicker()
  }

  datepickerCalendar.keypress(function () {
    return false
  })

  /**
   * File input
   */
  $(':file:not(.no-file-input)').each(function () {
    const $file = $(this)
    const id = $file.attr('id')
    let $replacement

    $file.filestyle({
      classButton: 'btn btn-primary btn-xs',
      classIcon: 'glyphicon glyphicon-folder-open',
      size: 'sm'
    })

    $replacement = $file.next('.bootstrap-filestyle')

    $replacement.find('input').removeClass('input-large').addClass('input-xs')
    $replacement.attr('id', 'filestyle-' + id)

    if ($file.is(':hidden')) {
      $replacement.css('display', 'none')
    }
  })

  /**
   * Tooltips
   */
  $('[title]').tooltip()

  /**
   * Empty lists
   */
  $('ul:not(:has(li))').append('<li class="list-group-item text-center">Empty list</li>')

  /**
   * Remember (and navigate) tabs
   */
  if (location.hash.substr(0, 1) === '#') {
    $("a[href$='#" + location.hash.substr(1) + "']").tab('show')
  }

  $(window).on('hashchange', function () {
    if (location.hash.substr(0, 1) === '#') {
      $("a[href$='#" + location.hash.substr(1) + "']").tab('show')
    }
  })

  $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
    location.hash = '#' + $(e.target).attr('href').substr(1)
  })

  /**
   * Table with fixed column
   */
  $('.table-responsive table.table').each(function () {
    const $table = $(this)
    const $fixedColumn = $table.clone().insertBefore($table).addClass('fixed-column')

    $fixedColumn.removeAttr('id')
    $fixedColumn.find('th:not(:first-child),td:not(:first-child)').remove()

    $fixedColumn.find('tr').each(function (i) {
      $(this).height($table.find('tr:eq(' + i + ')').height())
    })
  })

  /**
   * Tablesorter
   */
  $('.sort_table').tablesorter()
})

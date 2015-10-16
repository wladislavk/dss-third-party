$(document).ready(function(){
    function getParam (name) {
        var results = new RegExp('[?&]' + name + '=([^&#]*)').exec(window.location.href);
        return results !== null ? results[1] || '' : null;
    }

    function claimStatuses () {
        return {
            0: 'Primary - Pending',
            1: 'Primary - Sent',
            14: 'Primary - E-file Accepted',
            3: 'Primary - Paid Insurance',
            5: 'Primary - Paid Patient',
            4: 'Primary - Rejected',
            2: 'Primary - Dispute',
            10: 'Primary - Patient Dispute',

            6: 'Secondary - Pending',
            7: 'Secondary - Sent',
            15: 'Secondary - E-file Accepted',
            9: 'Secondary - Paid Insurance',
            11: 'Secondary - Paid Patient',
            13: 'Secondary - Rejected',
            8: 'Secondary - Dispute',
            12: 'Secondary - Patient Dispute'
        };
    }

    function mockFields () {
        function randomIndex (length) {
            index = Math.floor(Math.random()*length);

            if (index === length) {
                index--;
            }

            return index;
        }

        function randomDigits (amount) {
            var digits = '', n;

            for (n=0;n<amount;n++) {
                digits += randomIndex(10).toString();
            }

            return digits;
        }

        function fieldsGroupedByName (selector, action) {
            var names = {}, name;

            $(selector).each(function(){
                names[this.name] = this.name;
            });

            if ((typeof action).match(/object|function/)) {
                for (name in names) {
                    action(name);
                }
            }

            return names;
        }

        function randomizeRadios () {
            $(':radio').removeAttr('checked');

            fieldsGroupedByName(':radio', function(name){
                var options = $('[name="' + name + '"]'),
                    index = randomIndex(options.length);

                options.eq(index).attr('checked', true);
            });
        }

        function randomizeCheckboxes () {
            $(':checkbox').removeAttr('checked');

            fieldsGroupedByName(':checkbox', function(name){
                var $this = $('[name="' + name + '"]:checkbox');

                if (Math.random() <= 0.15) {
                    $this.attr('checked', true);
                }
            });
        }

        function randomizeDropdowns () {
            $('#claim-form select:not(.ui-datepicker-month, .ui-datepicker-year)').each(function(){
                var $this = $(this),
                    options = $this.find('option');

                $this.val(options.eq(randomIndex(options.length - 1) + 1).val());
            });
        }

        function randomizeAmounts () {
            var total = 0;

            $('[name*=outside_lab_charges]:text, [name*=charge_amount]:text').each(function(){
                var $this = $(this),
                    partial = (randomIndex(10000)/100).toFixed(2);

                if ($this.is('[name*=charge_amount]')) {
                    total += partial*1;
                }

                $(this).val(partial);
            });

            $('[name*=units]:text').each(function(){
                $(this).val(randomIndex(10) + 1);
            });

            $('[name*=total_charge]:text').val(total.toFixed(3));
            $('[name*=patient_amount_paid]:text, [name=amount_paid]:text').val((randomIndex(10000)/100).toFixed(2));
        }

        function randomizeNames () {
            $('[name*=first_name]:text, [name*=firstname]:text').each(function(){
                $(this).val(mockEntry().first);
            });

            $('[name*=last_name]:text, [name*=lastname]:text').each(function(){
                $(this).val(mockEntry().last);
            });

            $('[name*=middle_name]:text, [name*=_middle]:text').each(function(){
                $(this).val(mockEntry().first.substr(0, 1) + '.');
            });

            $('\
                [name*="[name]"]:not([class*=rendering_provider]):text, \
                [name*="[organization_name]"]:not([class*=rendering_provider]):text, \
                [name*=_name]:text, [name*=_plan]:text\
            ').each(function(){
                $(this).val(mockEntry().organization);
            });

            $('[name*="[npi]"]:text, [name=billing_provider_a], [name=service_info_a]').each(function(){
                $(this).val(mockEntry().npi);
            });

            $('[name*=tax_id]:text, [name*=taxonomy_code]:text, [name="subscriber[id]"]').each(function(){
                $(this).val(mockEntry().ssn);
            });
        }

        function randomizeAddresses () {
            $('[name*=state]').each(function(){
                var $this = $(this),
                    name = this.name,
                    entry = mockEntry();

                $this.val(entry.state);
                $('[name="' + name.replace('state', 'street_line_1') + '"]').val(entry.address);
                $('[name="' + name.replace('state', 'street_line_2') + '"]').val(entry.address_2);
                $('[name="' + name.replace('state', 'city') + '"]').val(entry.city);
            });

            $('[name*=_address]:text').each(function(){
                $(this).val(mockEntry().address);
            });

            $('[name=service_facility_info_city], [name=billing_provider_city]').each(function(){
                var entry = mockEntry();
                $(this).val(entry.city + ', ' + entry.state + ' ' + mock.zipCode());
            });
        }

        function randomizeDiagnosis () {
            $('\
                [name*=diagnosis_codes]:text, \
                [name=diagnosis_a], [name=diagnosis_b], [name=diagnosis_c], [name=diagnosis_d],\
                [name=diagnosis_e], [name=diagnosis_f], [name=diagnosis_g], [name=diagnosis_h],\
                [name=diagnosis_i], [name=diagnosis_j], [name=diagnosis_k], [name=diagnosis_l], \
            ').each(function(){
                $(this).val(mockEntry().diagnosis);
            });
        }

        function randomizeProcedures () {
            $('[name*=procedure_code]:text').each(function(){
                $(this).val(mockEntry().procedure);
            });

            $('[name*=procedure_modifiers]:text').each(function(){
                $(this).val(mockEntry().lorem);
            });
        }

        function mockEntry () {
            return mockData[randomIndex(mockData.length)];
        }

        var mock = {
            placeholder: function(){
                var texts = ['XXxxxxxx', 'yyyyyyyYY', 'zzzZZzzz', 'placeholderplaceholder'];
                return texts[randomIndex(texts.length)];
            },
            phoneNumber: function(){
                var areaCode = randomDigits(3); // randomIndex(10).toString().replace(/(.)/, '$1$1$1');

                return areaCode + randomDigits(7);
            },
            zipCode: function(){
                return randomDigits(5);
            },
            date: function(){
                var date = [1900 + randomIndex(116), randomIndex(13), randomIndex(31)];

                date = date.join('-');
                date = date.replace(/-(\d)-/, '-0$1-').replace(/-(\d)$/, '-0$1');

                return date;
            },
            gender: function(){
                var genders = ['m', 'f'];
                return genders[randomIndex(2)].toUpperCase();
            }
        };

        var placeholder = mock.placeholder(),
            phone = mock.phoneNumber(),
            zip = mock.zipCode(),
            state = mockEntry().state,
            date = mock.date();

        $(':text').val(placeholder);
        $('.datePicker, [data-date-format]').val(date);

        $('[name*=zip]:text').val(zip);
        $('[name=auto_accident_place]:text').val(state);
        $('[name*=icd_indicator]').val(randomDigits(2));

        $('[name*=phone]:text').each(function(){
            var $this = $(this);

            $this.val(phone);

            if ($this.is('.phonecodemask')) {
                $this.val(phone.substr(0, 3));
            } else if ($this.is('.phonemask')) {
                $this.val(phone.substr(3));
            }
        });

        randomizeCheckboxes();
        randomizeDropdowns();
        randomizeRadios();

        randomizeAmounts();

        randomizeNames();
        randomizeAddresses();

        randomizeDiagnosis();
        randomizeProcedures();

        if ($('[name=other_payer]:checked').val() !== 'true') {
            $('[name*=other_payers]:text').val('');

            $('[name="dependent[relationship]"]').removeAttr('checked');
            $('[name="dependent[relationship]"]:first').attr('checked', true);
        } else if ($('[name="dependent[relationship]"]:first:checked').length) {
            $('[name="dependent[relationship]"]').removeAttr('checked');
            $('[name="dependent[relationship]"][value=G8]').attr('checked', true);
        }

        $('[disabled]:text, select[disabled], .grayout :text, .grayout select').val('');
        $('[disabled]:radio, [disabled]:checkbox, .grayout :radio, .grayout :checkbox')
            .removeAttr('checked')
            .removeAttr('selected');
    }

    function compareFields (baseData) {
        function walkObject (object, name, action) {
            if ($.isPlainObject(object) || $.isArray(object)) {
                for (key in object) {
                    walkObject(
                        object[key],
                        name.length ? name + '[' + key + ']' : key,
                        action
                    );
                }
            } else {
                action(name, object);
            }
        }

        function markAs ($item, cssClass, title) {
            $item.closest('td').addClass(cssClass);

            if ((title || '').length) {
                $item.attr('title', title);
            }
        }

        $('form td').removeClass('debug-missing-data debug-extra-data debug-mismatch-data')
            .removeAttr('title');

        walkObject(baseData, '', function(name, value){
            var selector = '[name="' + name + '"]',
                $collection = $(selector),
                $reference = $collection.first(),
                fieldValue = $reference.val(),
                valueList = '',
                cssClass = '';

            value = (value || '').toString();

            // Assume only the radio buttons can have multiple matches
            if ($reference.is(':radio')) {
                $reference = $collection.filter(':checked');
                fieldValue = $reference.val();

                // We can be dealing with a true|false couple
                $collection.each(function(){
                    valueList += $(this).val();
                });

                if (valueList.match(/^truefalse|falsetrue$/)) {
                    value = !!value.toLowerCase().match(/true|yes|y|on|1/);
                    fieldValue = fieldValue === 'true';
                }

                if (value !== fieldValue) {
                    cssClass = 'debug-mismatch-data';
                }
            } else if ($reference.is(':checkbox')) {
                fieldValue = $reference.is(':checked');
                value = !!value.toLowerCase().match(/true|yes|y|on|1/);

                if (value !== fieldValue) {
                    cssClass = 'debug-mismatch-data';
                }
            } else {
                if (value.length && !fieldValue.length) {
                    cssClass = 'debug-missing-data';
                } else if (!value.length && fieldValue.length) {
                    cssClass = 'debug-extra-data';
                } else if (value !== fieldValue) {
                    cssClass = 'debug-mismatch-data';
                }
            }

            if (cssClass) {
                markAs($collection, cssClass, value);
            }
        });
    }

    function submitAndCompare () {
        var $form = $('form#claim-form'),
            formData = $form.serialize(),
            activeFields = $form.find('input:not([disabled]), select:not([disabled])');

        debugLog('Submitting form via ajax...');

        function refreshIframe (action) {
            var location = window.location.href,
                iframe = $('iframe#comparison-form');

            iframe.remove();

            iframe = $('<iframe>', {
                id: 'comparison-form',
                style: 'display:none;',
                src: location + '&v=' + Math.random()
            }).load(function(){
                action(iframe.contents().find('form#claim-form'));
            }).appendTo('body');
        }

        function highlightElement ($element, value) {
            $element.addClass('debug-missing-data')
                .attr('title', value.length ? 'New value: ' + value : 'The new value is empty')
                .closest('td').addClass('debug-mismatch-data');
        }

        function compareForms ($currentForm, $newForm) {
            var $currentFields = $currentForm.find('input[name], select[name]'),
                $newFields = $newForm.find('input[name], select[name]'),
                fields = {}, debug = '';

            $currentForm.find('td').removeClass('debug-mismatch-data');

            $currentFields.each(function(){
                var $this = $(this),
                    $counterPart = $newForm.find('[name="' + this.name + '"]'),
                    currentValue, newValue;

                if (!this.name.length) {
                    return;
                }

                if (!$counterPart.length) {
                    fields[this.name] = this.name;
                    highlightElement($this, '<The field is no longer in the form>');
                } else if ($this.is(':radio') || $this.is(':checkbox')) {
                    $counterPart = $newForm.find('[name="' + this.name + '"][value="' + $this.val() + '"]');

                    if ($this.is(':checked') !== $counterPart.is(':checked')) {
                        fields[this.name] = this.name;
                        highlightElement($this, $counterPart.is(':checked').toString());
                    }
                } else if ($this.val() !== $counterPart.val()) {
                    fields[this.name] = this.name;
                    highlightElement($this, $counterPart.val());
                }
            });

            for (n in fields) {
                debug += '\n' + n;
            }

            if (debug.length) {
                debugLog('<pre>Mismatched fields:\n' + debug + '</pre>', true);
            } else {
                debugLog('False alarm, all is good!');
            }
        }

        activeFields.addClass('submission-disabled').attr('disabled', true);
        $form.find('[class*=debug-]').removeClass('debug-mismatch-data debug-missing-data debug-empty-data');
        $form.find('[title]').removeAttr('title');

        $.ajax({
            url: $form.attr('action') + '&json=1',
            data: formData,
            type: 'post',
            error: function(){
                debugLog('There was an error saving the claim.');
            },
            success: function(){
                debugLog('Save successful. Preparing to load the updated claim form in the background...');

                refreshIframe(function($newForm){
                    if (!$newForm.length) {
                        debugLog('There was an error when trying to load the updated claim form in the background.');
                    }

                    if (formData === $newForm.serialize()) {
                        debugLog('The form fields are the same after saving.');
                        return;
                    }

                    debugLog('There are differences in the updated claim form. Calculating differences...');
                    compareForms($form, $newForm);
                });
            },
            complete: function(){
                activeFields.removeClass('submission-disabled').removeAttr('disabled');
            }
        });
    }

    function compareSideBySide () {
        setTimeout(function(){
            var paper = $('<iframe>', {
                    style: 'width: 100%; height: 500px;',
                    src: '/manage/insurance_v2.php?insid=130&pid=10'
                }),
                efile = $('<iframe>', {
                    style: 'width: 100%; height: 500px;',
                    src: '/manage/insurance_eligible.php?insid=130&pid=10'
                }),
                mapping = {},
                paperCandidate, efileCandidate,
                efileToPaperMap = {};

            function compareForms () {
                var efileFieldName, paperFieldName,
                    $efileField, $paperField,
                    method, valuesDiffer;

                efile.contents().find('[name]').removeClass('debug-extra-data debug-mismatch-data');
                paper.contents().find('[name]').removeClass('debug-extra-data debug-mismatch-data');

                for (paperFieldName in efileToPaperMap) {
                    efileFieldName = efileToPaperMap[paperFieldName];

                    if (typeof efileFieldName !== 'string') {
                        // Ignore comparison function by now, but retrieve it anyway
                        method = ClaimFormDataMapperHelper.last(efileFieldName);
                        efileFieldName = ClaimFormDataMapperHelper.head(efileFieldName);
                    }

                    efileFieldName = ClaimFormDataMapperHelper.dotNotationToBrackets(efileFieldName);
                    paperFieldName = ClaimFormDataMapperHelper.dotNotationToBrackets(paperFieldName);

                    $efileField = efile.contents().find('#claim-form [name="' + efileFieldName + '"]');
                    $paperField = paper.contents().find('#claim-form [name="' + paperFieldName + '"]');

                    if ($efileField.is(':radio, :checkbox')) {
                        // Instead of using a comparison function, assume checkboxes and radio buttons
                        // are in the exact same order in each form
                        valuesDiffer = $efileField.index($efileField.find(':checked')) !==
                            $paperField.index($paperField.find(':checked'));
                    } else if ($paperField.length && $paperField.attr('name').match(/_phone/)) {
                        // Some phone fields are separated in code and phone in paper, but whole phone in e-file
                        if ($paperField.attr('name').match(/_phone_code/)) {
                            valuesDiffer = $efileField.val() !== $paperField.val() &&
                                $efileField.val().substr(0, 3) !== $paperField.val();
                        } else {
                            valuesDiffer = $efileField.val() !== $paperField.val() &&
                                $efileField.val().substr(3) !== $paperField.val();
                        }
                    } else {
                        valuesDiffer = $efileField.val() !== $paperField.val();
                    }

                    if (valuesDiffer) {
                        $efileField.addClass('debug-extra-data');
                        $paperField.addClass('debug-extra-data');
                    } else {
                        $efileField.addClass('debug-mismatch-data');
                        $paperField.addClass('debug-mismatch-data');
                    }
                }
            }

            $('body')
                .css({
                    background: '#fff',
                    height: '100%'
                })
                .html($('<table>', {
                    cellpadding: 5,
                    cellspacing: 0,
                    border: 0,
                    width: '100%',
                    height: '100%'
                }))
                .append($('<script>', {
                    src: '/manage/js/claim-tools.js'
                }));

            $('table')
                .append('<tr height="500"><td id="paper-iframe"></td><td id="efile-iframe"></tr>')
                .append('<tr style="font-size:1em;font-weight:bold;"><td style="text-align:right"><code id="paper-candidate"></code></td><td><code id="efile-candidate"></code></tr>')
                .append('<tr><td id="actions" style="text-align:center" colspan="2"></td></tr>');

            $('#paper-iframe').append(paper);
            $('#efile-iframe').append(efile);
            $('#actions')
                .append($('<button>Compare forms</button>').click(function(){
                    compareForms();
                }));
            /**
             * Buttons to help map/match form fields
                .append($('<button>Save</button>').click(function(){
                    mapping[paperCandidate] = efileCandidate;
                    paper.contents().find('[name="' + paperCandidate + '"]').addClass('debug-mismatch-data');
                    efile.contents().find('[name="' + efileCandidate + '"]').addClass('debug-mismatch-data');
                }))
                .append($('<button style="float:right">Report</button>').click(function(){
                    console.info(mapping);
                    console.info(JSON.stringify(mapping));
                }))
             */

            paper.load(function(){
                console.info('paper iframe ready!');
                /**
                 * Action to help map/match form fields
                paper.contents().find('#claim-form [name]').click(function(){
                    var $this = $(this),
                        $form = $this.closest('form');

                    $form.find('.debug-extra-data').removeClass('debug-extra-data');
                    $form.find('[name="' + this.name + '"]').addClass('debug-extra-data');

                    paperCandidate = this.name;
                    $('#paper-candidate').text(paperCandidate);
                });
                 */
            });

            efile.load(function(){
                console.info('e-file iframe ready!');
                /**
                 * Action to help map/match form fields
                efile.contents().find('#claim-form [name]').click(function(){
                    var $this = $(this),
                        $form = $this.closest('form');

                    $form.find('.debug-extra-data').removeClass('debug-extra-data');
                    $form.find('[name="' + this.name + '"]').addClass('debug-extra-data');

                    efileCandidate = this.name;
                    $('#efile-candidate').text(efileCandidate);
                });
                 */
            });

            $.ajax({
                url: '/manage/insurance-form.php',
                data: { map: 'efile-to-paper', expanded: true },
                dataType: 'json',
                success: function(map){
                    console.info('data map ready!');
                    efileToPaperMap = map;
                },
                error: function(){ console.info('data map failed!'); }
            });
        }, 100);
    }

    function changeClaimStatus (status) {
        if (!status.length) {
            return;
        }

        debugLog('Changing claim status to "' + claimStatuses()[status] + '"');

        $.ajax({
            url: '/manage/insurance-form.php',
            type: 'get',
            data: { insid: getParam('insid'), status: status },
            success: function(){
                debugLog('Status changed successfully to "' + claimStatuses()[status] + '"');
            }
        });
    }

    function debugLog (message, asHtml) {
        if (asHtml) {
            $('#debug-notifications').html(message);
        } else {
            $('#debug-notifications').text(message);
        }
    }

    $('<div>', {
        id: 'debug-buttons'
    }).appendTo('body');

    $('<button>', {
        class: 'dummy-data',
        text: 'Fill dummy data'
    }).click(function(){ mockFields(); }).prependTo('#debug-buttons');

    $('<button>', {
        class: 'save-ajax-data',
        text: 'Save without reload the page'
    }).click(function(){ submitAndCompare(); }).prependTo('#debug-buttons');

    $('<select>', {
        name: 'claim-status'
    }).each(function(){
            var $this = $(this),
                statuses = claimStatuses(),
                n;

            $this.append('<option>Select a status</option>');

            for (n in statuses) {
                $this.append('<option value="' + n + '">' + statuses[n] + '</option>');
            }
        })
        .change(function(){ changeClaimStatus($(this).val()); }).prependTo('#debug-buttons');

    $('<div>', {
        id: 'debug-notifications'
    }).prependTo('#debug-buttons');

    if (false) {
        $('<button>', {
            class: 'compare-data',
            text: 'Compare base data with current form'
        }).click(function(){ compareFields(formData); }).prependTo('#debug-buttons');
    }

    window.mockFields = mockFields;
    window.compareFields = compareFields;
    window.compareSideBySide = compareSideBySide;
});

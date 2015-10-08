$(document).ready(function(){
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
            $('select:not(.ui-datepicker-month, .ui-datepicker-year)').each(function(){
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
            $('[name*=patient_amount_paid]:text').val((randomIndex(10000)/100).toFixed(3));
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
            $('[name*=state]:text').each(function(){
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
        $('[name=auto_accident_place]]:text').val(state);

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

        $('[disabled]:text, .grayout :text').val('');
    }

    $('form').submit(function(e){
        e.preventDefault();

        var $form = $(this),
            formData = $form.serialize(),
            activeFields = $form.find('input:not([disabled]), select:not([disabled])');

        activeFields.addClass('submission-disabled').attr('disabled', true);

        $.ajax({
            url: $form.attr('action') + '&json=1',
            data: formData,
            type: 'post',
            success: function(data){
                $.ajax({
                    url: window.location.href + '&json=1',
                    dataType: 'json',
                    success: function(data){
                        compareFields(data);
                    }
                })
            },
            complete: function(){
                activeFields.removeClass('submission-disabled').removeAttr('disabled');
            }
        });

        return false;
    });

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

    $('<div>', {
        id: 'debug-buttons'
    }).appendTo('body');

    $('<button>', {
        class: 'dummy-data',
        text: 'Fill dummy data'
    }).click(function(){ mockFields(); }).appendTo('#debug-buttons');

    // Enable after refactoring the claim file
    if (false) {
        $('<button>', {
            class: 'compare-data',
            text: 'Compare base data with current form'
        }).click(function(){ compareFields(formData); }).appendTo('#debug-buttons');
    }

    window.mockFields = mockFields;
    window.compareFields = compareFields;
});
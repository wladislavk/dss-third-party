jQuery(function($){
    var $hstForm = $('#hst_order_sleep_services'),
        $hstRadioButtons = $('[name=hst_type]:radio'),
        $hstContainers = $hstRadioButtons.closest('li'),
        $hstCompanySelector = $(':radio[name=company_id]'),
        $insuranceCompanySelector = $('select[name=ins_co_id]'),
        $providerSelector = $('#provider_selector');

    $hstRadioButtons.change(function(){
        $hstContainers.find('.container').hide();
        $(this).closest('li').find('.container').show();
    });

    $('[name=hst_3_nights]').change(function(){
        var $this = $(this),
            $container = $hstContainers.last().find('.container'),
            $fields = $container.find('span.field-position'),
            $first = $fields.first(),
            $rest = $fields.not(':eq(0)'),
            $clone;

        $rest.remove();

        for (var n=1;n<$this.val();n++) {
            $clone = $first.clone();
            $clone.find('input').attr('id', 'device-position-' + n).attr('name', 'hst_device_position[' + n + ']');
            $clone.find('label').attr('for', 'device-position-' + n).text('For night ' + (n + 1));
            $clone.appendTo($container);
        }
    });

    $providerSelector.change(function(){
        var providerId = $(this).val(),
            provider, fieldName;

        if (typeof providerList === 'undefined' || !providerList[providerId]) {
            return;
        }

        provider = providerList[providerId];

        for (fieldName in provider) {
            if (!fieldName.match(/^provider_/)) {
                continue;
            }

            $hstForm.find('[name="' + fieldName + '"]').val(provider[fieldName]);
        }
    });

    $insuranceCompanySelector.change(function(){
        var companyId = $(this).val(),
            $phone = $hstForm.find('[name=ins_phone]'),
            phoneNumber;

        if (!insuranceCompanyList.hasOwnProperty(companyId)) {
            return;
        }

        phoneNumber = insuranceCompanyList[companyId].phone;
        $phone.val(phoneNumber)
            .focus().blur();

        /**
         * Forcing the mask might cause the number to disappear, let's reset the value
         */
        if (phoneNumber.length && !$phone.val()) {
            $phone.val(phoneNumber);
        }
    });

    $hstCompanySelector.change(function(){
        var companyId = $(this).val();

        if (!hstCompanyList.hasOwnProperty(companyId)) {
            return;
        }

        $('#hst-company-name').text(hstCompanyList[companyId].name);
        $('#hst-company-phone').text(hstCompanyList[companyId].phone);
        $('#hst-company-fax').text(hstCompanyList[companyId].fax);
        $('#hst-company-email').text(hstCompanyList[companyId].email);
    });

    /**
     * Flag to determine which button was pressed
     */
    $hstForm.find('[type=submit]').click(function(){
        $hstForm.data('action', $(this).attr('name'));
    });

    $hstForm.submit(function(){
        var $required, confirmation;

        /**
         * Don't run validation on non authorization request
         */
        if ($hstForm.data('action') === 'save') {
            return true;
        }

        $hstForm.find(':text:visible:not([name=patient_add2])').each(function(){
            var $this = $(this);
            $this.toggleClass('required', !$this.val().trim().length);
        });

        $hstForm.find('select').each(function(){
            var $this = $(this),
                $parent = $this.closest('li'),
                $radio = $parent.find(':radio');

            /**
            * If the parent has a radio button, the select field relies on it
            */
            if ($radio.length) {
                $this.toggleClass('required', $radio.is(':checked') && !$this.val());
            } else {
                $this.toggleClass('required', !$this.val());
            }
        });

        if ($hstForm.find('select#ins_co_id').val() === '0') {
            $hstForm.find('[name=ins_phone], [name=patient_ins_id], [name=patient_ins_group_id]')
                .removeClass('required');
        }

        $hstForm.find('ul.frmhead:has(:radio)').each(function(){
            var $this = $(this),
                fieldName = $this.find(':radio:first').attr('name');

            $this.toggleClass('required', !$this.find('[name="' + fieldName + '"]:checked').length);
        });

        $required = $hstForm.find('.required');

        if ($required.length) {
            if ($required.length === 1 && $required.is('[name=patient_email]')) {
                confirmation = confirm('Missing Patient Email. Do you still want to order the test?');
                return confirmation;
            } else {
                alert('All the form fields are required');
                return false;
            }
        }

        return true;
    });

    /**
     * If edit form mode, detect empty contact fields and populate them
     * If view form mode, disable fields
     */
    if ($('[type=submit]').length) {
        if (
            (
                !$hstForm.find('[name^=provider_]:not([type=hidden], [name=provider_selector])').val() ||
                !$hstForm.find('[name=hst_id]').val()
            )
            && $providerSelector.val()
        ) {
            $providerSelector.change();
        }
    } else {
        $hstForm.find('input, select')
            .not(':radio:checked')
            .prop('disabled', true);

        $('#hst_order_sleep_services').find('.submit-action').hide();
    }
}(jQuery));
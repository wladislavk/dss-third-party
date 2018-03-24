<?php

namespace DentalSleepSolutions\Providers;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;
use Illuminate\Foundation\Providers\FormRequestServiceProvider as BaseServiceProvider;

class FormRequestServiceProvider extends BaseServiceProvider
{
    /**
     * Initialize the form request with data from the given request.
     *
     * @param FormRequest $form
     * @param Request $current
     * @return void
     */
    protected function initializeRequest(FormRequest $form, Request $current)
    {
        parent::initializeRequest($form, $current);

        if (
            method_exists($form, 'setAdminResolver')
            && method_exists($current, 'getAdminResolver')
        ) {
            $form->setAdminResolver($current->getAdminResolver());
        }

    }
}

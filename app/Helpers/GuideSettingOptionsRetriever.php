<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingOptionRepository;

class GuideSettingOptionsRetriever
{
    /**
     * @var GuideSettingOptionRepository
     */
    private $guideSettingOptionRepository;

    public function __construct(GuideSettingOptionRepository $guideSettingOptionRepository)
    {
        $this->guideSettingOptionRepository = $guideSettingOptionRepository;
    }

    /**
     * @return array|\Illuminate\Database\Eloquent\Collection[]
     */
    public function get()
    {
        $guideSettingOptions = $this->guideSettingOptionRepository->getOptionsBySettingIds();

        if (empty($guideSettingOptions)) {
            return [];
        }

        foreach ($guideSettingOptions as $setting) {
            $setting->labels = explode(',', $setting->labels);
        }

        return $guideSettingOptions;
    }
}

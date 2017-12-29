<?php

namespace DentalSleepSolutions\Helpers;

use DentalSleepSolutions\Eloquent\Repositories\Dental\GuideSettingOptionRepository;
use DentalSleepSolutions\Structs\GuideSettingOption;

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
     * @return array|GuideSettingOption[]
     */
    public function get()
    {
        $guideSettingOptions = $this->guideSettingOptionRepository->getOptionsBySettingIds();

        if (empty($guideSettingOptions)) {
            return [];
        }

        $options = [];
        foreach ($guideSettingOptions as $setting) {
            $guideSettingOption = new GuideSettingOption();
            $guideSettingOption->id = $setting->id;
            $guideSettingOption->labels = explode(',', $setting->labels);
            $guideSettingOption->name = $setting->name;
            $guideSettingOption->settingType = $setting->setting_type;
            $guideSettingOption->number = $setting->number;

            $options[] = $guideSettingOption;
        }

        return $options;
    }
}

<?php

namespace DentalSleepSolutions\Services\GuideSettingOptions;

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
     * @return GuideSettingOption[]
     */
    public function get()
    {
        $guideSettingOptions = $this->guideSettingOptionRepository->getOptionsBySettingIds();
        $options = [];
        foreach ($guideSettingOptions as $setting) {
            $guideSettingOption = new GuideSettingOption();
            $guideSettingOption->id = $setting['id'];
            $guideSettingOption->labels = explode(',', $setting['labels']);
            $guideSettingOption->name = $setting['name'];
            $guideSettingOption->number = $setting['number'];

            $options[] = $guideSettingOption;
        }
        return $options;
    }
}

<?php

namespace DentalSleepSolutions\Contracts\Repositories;

interface DocumentCategories extends Repository
{
    public function getActiveDocumentCategories();
}

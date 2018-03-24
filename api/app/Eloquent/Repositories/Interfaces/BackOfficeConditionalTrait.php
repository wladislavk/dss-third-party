<?php

namespace DentalSleepSolutions\Eloquent\Repositories\Interfaces;

trait BackOfficeConditionalTrait
{
    /**
     * @param string $claimAlias
     * @return string
     */
    public function filedByBackOfficeConditional($claimAlias)
    {
        return "(
                -- Filed by back office, legacy logic
                COALESCE(IF($claimAlias.primary_claim_id, $claimAlias.s_m_dss_file, $claimAlias.p_m_dss_file), 0) = 1
                -- Filed by back office, new logic
                OR COALESCE($claimAlias.p_m_dss_file, 0) = 3
            )";
    }
}

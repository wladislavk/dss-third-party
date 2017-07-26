<?php

namespace DentalSleepSolutions\Eloquent\Models;

/**
 * @SWG\Definition(
 *     definition="FlowsheetSegment",
 *     type="object",
 *     required={"id", "section", "content", "sortby"},
 *     @SWG\Property(property="id", type="integer"),
 *     @SWG\Property(property="section", type="string"),
 *     @SWG\Property(property="content", type="string"),
 *     @SWG\Property(property="sortby", type="integer")
 * )
 *
 * DentalSleepSolutions\Eloquent\Models\FlowsheetSegment
 *
 * @property int $id
 * @property string $section
 * @property string $content
 * @property int $sortby
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\FlowsheetSegment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\FlowsheetSegment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\FlowsheetSegment whereSection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\DentalSleepSolutions\Eloquent\Models\FlowsheetSegment whereSortby($value)
 */
class FlowsheetSegment extends AbstractModel
{
    /**
     * Guarded attributes
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'flowsheet_segments';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}

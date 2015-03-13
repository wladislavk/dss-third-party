<?php namespace Ds3\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;

use Ds3\Contracts\QImageInterface;
use Ds3\Eloquent\QImage;

class QImageRepository implements QImageInterface
{
    public function get($imageId)
    {
        try {
            $qImage = QImage::where('imageid', '=', $imageId)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return false;
        }

        return $qImage;
    }

    public function getImage($imageTypeId, $patientId, $order = null)
    {
        $image = QImage::where('imagetypeid', '=', $imageTypeId)
            ->where('patientid', '=', $patientId);

        if (!empty($order)) {
            $image = $image->orderBy($order, 'desc');
        }

        return $image->get();
    }

    public function insertData($data)
    {
        $qImage = new QImage();

        foreach ($data as $attribute => $value) {
            $qImage->$attribute = $value;
        }

        try {
            $qImage->save();
        } catch (QueryException $e) {
            return null;
        }

        return $qImage->imageid;
    }

    public function updateData($where, $values)
    {
        $qImage = new QImage();

        foreach ($where as $attribute => $value) {
            $qImage = $qImage->where($attribute, '=', $value);
        }

        $qImage = $qImage->update($values);

        return $qImage;
    }
}

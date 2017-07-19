<?php

namespace DentalSleepSolutions\Helpers;

use Barryvdh\DomPDF\PDF;
use DentalSleepSolutions\Eloquent\Models\Dental\User;
use DentalSleepSolutions\Eloquent\Models\Dental\Letter;
use DentalSleepSolutions\Structs\PdfData;
use DentalSleepSolutions\Structs\PdfHeaderData;
use DentalSleepSolutions\Wrappers\FileWrapper;
use Illuminate\Routing\UrlGenerator;

class PdfHelper
{
    const LETTER_PDF_FOLDER = 'letter_pdfs/';

    /** @var PDF */
    private $domPdfWrapper;

    /** @var UrlGenerator */
    private $urlGenerator;

    /** @var FileWrapper */
    private $fileWrapper;

    /** @var User */
    private $userModel;

    /** @var Letter */
    private $letterModel;

    public function __construct(
        PDF $domPdfWrapper,
        UrlGenerator $urlGenerator,
        FileWrapper $fileWrapper,
        User $userModel,
        Letter $letterModel
    ) {
        $this->domPdfWrapper = $domPdfWrapper;
        $this->urlGenerator = $urlGenerator;
        $this->fileWrapper = $fileWrapper;
        $this->userModel = $userModel;
        $this->letterModel = $letterModel;
    }

    /**
     * TODO: the last argument is never used
     *
     * @param string $template
     * @param array $content
     * @param string $filename
     * @param PdfHeaderData|null $headerInfo
     * @param int $docId
     * @param int $letterId
     * @return string
     */
    public function create($template, array $content, $filename, PdfHeaderData $headerInfo = null, $docId = 0, $letterId = 0)
    {
        $pdfData = new PdfData();
        $pdfData->content = $content;
        if ($headerInfo) {
            $pdfData->headerData = $headerInfo;
        }

        $letterPdfPath = $this->fileWrapper->getPublicPath() . '/' . self::LETTER_PDF_FOLDER;
        $letterPdfFilename = $letterPdfPath . $filename;

        if ($docId) {
            $this->addDoctorData($docId, $letterId, $pdfData);
        }
        $this->domPdfWrapper->loadView($template, $pdfData->toArray());
        $this->domPdfWrapper->save($letterPdfFilename);

        return $this->urlGenerator->to(self::LETTER_PDF_FOLDER . $filename);
    }

    private function addDoctorData($docId, $letterId, PdfData $pdfData)
    {
        /** @var User|null $doctor */
        $doctor = $this->userModel->find($docId);
        // TODO: what is 2?
        if (!$doctor || $doctor->user_type != 2) {
            return;
        }
        $pdfData->marginData->top = $doctor->letter_margin_top;
        $pdfData->marginData->left = $doctor->letter_margin_left;
        $pdfData->marginData->right = $doctor->letter_margin_right;
        $pdfData->marginData->bottom = $doctor->letter_margin_bottom;
        $pdfData->marginData->header = $doctor->letter_margin_header;
        $pdfData->marginData->footer = $doctor->letter_margin_footer;
        if (!$letterId) {
            return;
        }
        /** @var Letter|null $letter */
        $letter = $this->letterModel->find($letterId);
        if ($letter) {
            $pdfData->fontData->family = $letter->font_family;
            $pdfData->fontData->size = $letter->font_size;
        }
    }
}

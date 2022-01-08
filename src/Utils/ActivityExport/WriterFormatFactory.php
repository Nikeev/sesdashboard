<?php

namespace App\Utils\ActivityExport;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

class WriterFormatFactory
{
    const FORMAT_EXCEL = 'excel';
    const FORMAT_CSV = 'csv';

    public function get(string $format)
    {
        if (!in_array($format, [self::FORMAT_EXCEL, self::FORMAT_CSV])) {
            throw new \Exception('Wrong export format');
        }

        switch ($format) {
            case self::FORMAT_EXCEL:
                return WriterEntityFactory::createXLSXWriter();
            case self::FORMAT_CSV:
                return WriterEntityFactory::createCSVWriter();
        }
    }
}
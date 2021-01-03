<?php


namespace App\Utils;


use Symfony\Component\HttpFoundation\Request;

class ActivitySearchFilters
{
    public function getFiltersFromRequest(Request $request): array
    {
        $filters = [];

        $filters['search'] = $request->get('search');

        if ($dateFrom = $request->get('dateFrom')) {
            try {
                $filters['dateFrom']  = (new \DateTime($dateFrom))->setTime(0, 0, 0);
            } catch (\Exception $e) {
                throw new \Exception('Wrong dateFrom parameter!');
            }
        }

        if ($dateTo = $request->get('dateTo')) {
            try {
                $filters['dateTo']  = (new \DateTime($dateTo))->setTime(23, 59, 59);
            } catch (\Exception $e) {
                throw new \Exception('Wrong dateTo parameter!');
            }
        }

        return $filters;
    }
}
<?php


namespace App\Utils;


use Symfony\Component\HttpFoundation\Request;

class ActivitySearchFilters
{
    public function getFiltersFromRequest(Request $request): array
    {
        $filters = [];

        if ($request->get('search')) {
            $filters['search'] = $request->get('search');
        }

        if ($request->get('eventType')) {
            $filters['eventType'] = $request->get('eventType');
        }

        if ($dateFrom = $request->get('dateFrom')) {
            try {
                $filters['dateFrom']  = new \DateTime($dateFrom);
            } catch (\Exception $e) {
                throw new \Exception('Wrong dateFrom parameter!');
            }
        }

        if ($dateTo = $request->get('dateTo')) {
            try {
                $filters['dateTo']  = new \DateTime($dateTo);
            } catch (\Exception $e) {
                throw new \Exception('Wrong dateTo parameter!');
            }
        }

        return $filters;
    }
}
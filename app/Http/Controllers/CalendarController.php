<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function calendar(Request $request)
    {
        $today = Carbon::createFromDate($request->year, $request->month, $request->day);
        if($request->has('order') && $request->order)
        {
            if($request->order == 'next')
            {
                $today = $today->addMonth();
            } 
            else if($request->order == 'prev')
            {
                $today = $today->subMonth();
            }
        }
        $first = Carbon::createFromDate($today->year, $today->month, 1);

        for($i=1; $i < $first->daysInMonth + 1; ++$i) {
            $dates[$i] = Carbon::createFromDate($first->year, $first->month, $i)->toDateString();
        }
        if($first->dayOfWeek > 0) {
            $sunday = $first->subDays($first->dayOfWeek);
            for($i=$sunday->day; $i < $sunday->daysInMonth + 1; ++$i) {
                $prevDates[$i] = Carbon::createFromDate($sunday->year, $sunday->month, $i)->toDateString();
            }
        }
        $last = Carbon::createFromDate($today->year, $today->month, $today->daysInMonth);
        if($last->dayOfWeek < 6) {
            $saturday = $last->addDays(6 - $last->dayOfWeek);
            for($i=1; $i < $saturday->day + 1; ++$i) {
                $nextDates[$i] = Carbon::createFromDate($saturday->year, $saturday->month, $i)->toDateString();
            }
        }

        return response()->json([
            'today' => $today->toDateString(),
            'dates' => json_encode($dates),
            'prevDates' => json_encode(isset($prevDates) ? $prevDates : ''),
            'nextDates' => json_encode(isset($nextDates) ? $nextDates : '')
        ]);
    }
}

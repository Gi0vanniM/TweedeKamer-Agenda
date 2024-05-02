<?php

namespace App\Http\Controllers;

use App\Models\AgendaItem;
use DateTime;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Carbon;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(string $date = null)
    {
        // if $date not given, set current date
        if ($date === null) {
            $date = date('d-m-Y');
        }
        // create the carbon object
        $date = Carbon::createFromFormat(
            'd-m-Y',
            $date,
            'Europe/Amsterdam'
        );
        // get the selected day
        $selectedDate = $date->copy();
        // get the first day (monday) of the previous and next week
        $prevWeek = $date->copy()->subWeek()->isoWeekday(1)->format('d-m-Y');
        $nextWeek = $date->copy()->addWeek()->isoWeekday(1)->format('d-m-Y');

        for ($day = 1; $day <= 7; $day++) {
            $week[] = [
                'dayName' => ($date->isoWeekday($day)->dayName),
                'date' => $date->isoWeekday($day)->format('d-m-Y'),
                'dateText' => $date->isoFormat('D MMM YYYY'),
            ];
        }

        // get the agenda items
        $fromDate = $selectedDate->format('Y-m-d');
        $agendaItems = AgendaItem::where('from_date', $fromDate)
        ->orderBy('from_date', 'asc')
        ->orderBy('from_time', 'asc')
        ->orderByRaw('FIELD(type, "Plenair debat")')
        ->get();

        return Inertia::render('agenda/index', [
            'selectedDate' => [
                'date' => $selectedDate->format('d-m-Y'),
                'dayName' => $selectedDate->dayName,
            ],
            'agendaItems' => $agendaItems,
            'week' => $week,
            'prevWeek' => $prevWeek,
            'nextWeek' => $nextWeek,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
}

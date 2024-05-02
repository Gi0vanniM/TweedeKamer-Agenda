<?php

namespace App\Http\Controllers;

use App\Models\AgendaItem;
use App\Models\ParliamentMember;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AgendaItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('agenda/edit', [
            'action' => 'create',
            'users' => User::all(),
            'parliamentMembers' => ParliamentMember::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // check if necessary data is sent, if something is missing return an error response
        if (
            !isset($request->title)
            || !isset($request->from_date)
            || !isset($request->from_time)
            || !isset($request->to_time)
            || !isset($request->to_date)
        ) {
            return response()->json(
                ['error' => 'missing data']
            );
        }

        $agendaItem = new AgendaItem();
        $agendaItem->title = $request->title ?? null;
        $agendaItem->agenda_type_id = 1;
        $agendaItem->description = $request->description ?? null;
        $agendaItem->from_date = $request->from_date ?? null;
        $agendaItem->from_time = $request->from_time ?? null;
        $agendaItem->to_date = $request->to_date ?? null;
        $agendaItem->to_time = $request->to_time ?? null;
        $agendaItem->type = $request->type ?? null;
        $agendaItem->commission = $request->commission ?? null;

        if (isset($request->parliamentMembers)) {
            $agendaItem->parliamentMembers()->sync($request->parliamentMembers);
        }

        if (isset($request->users)) {
            $agendaItem->users()->sync($request->users);
        }

        if (!$agendaItem->save()) {
            return response()->json(
                ['error' => 'something went wrong saving agenda item']
            );
        }

        return response()->json(
            [
                'status' => true,
                'data' => [
                    'agendaItem' => $agendaItem,
                ],
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AgendaItem  $agendaItem
     * @return \Illuminate\Http\Response
     */
    public function show(AgendaItem $agendaItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AgendaItem  $agendaItem
     * @return \Illuminate\Http\Response
     */
    public function edit(AgendaItem $agendaItem)
    {
        return Inertia::render('agenda/edit', [
            'action' => 'edit',
            'agendaItem' => [
                'id' => $agendaItem->id,
                'title' => $agendaItem->title,
                'description' => $agendaItem->description,
                'from_date' => $agendaItem->from_date,
                'from_time' => $agendaItem->from_time,
                'to_date' => $agendaItem->to_date,
                'to_time' => $agendaItem->to_time,
                'type' => $agendaItem->type,
                'commission' => $agendaItem->comission,
                'parliamentMembers' => $agendaItem->parliamentMembers->pluck('id')->toArray(),
                'users' => $agendaItem->users->pluck('id')->toArray(),
            ],
            'users' => User::all(),
            'parliamentMembers' => ParliamentMember::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AgendaItem  $agendaItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AgendaItem $agendaItem)
    {
        // check if necessary data is sent, if something is missing return an error response
        if (
            !isset($request->title)
            || !isset($request->from_date)
            || !isset($request->from_time)
            || !isset($request->to_time)
            || !isset($request->to_date)
        ) {
            return response()->json(
                ['error' => 'missing data']
            );
        }

        $agendaItem->title = $request->title ?? null;
        $agendaItem->agenda_type_id = 1;
        $agendaItem->description = $request->description ?? null;
        $agendaItem->from_date = $request->from_date ?? null;
        $agendaItem->from_time = $request->from_time ?? null;
        $agendaItem->to_date = $request->to_date ?? null;
        $agendaItem->to_time = $request->to_time ?? null;
        $agendaItem->type = $request->type ?? null;
        $agendaItem->commission = $request->commission ?? null;

        if (isset($request->parliamentMembers)) {
            $agendaItem->parliamentMembers()->sync($request->parliamentMembers);
        }

        if (isset($request->users)) {
            $agendaItem->users()->sync($request->users);
        }

        if (!$agendaItem->update()) {
            return response()->json(
                ['error' => 'something went wrong saving agenda item']
            );
        }

        return response()->json(
            [
                'status' => true,
                'data' => [
                    'agendaItem' => $agendaItem,
                ],
            ]
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AgendaItem  $agendaItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(AgendaItem $agendaItem)
    {
        //
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\ParliamentMember;
use Illuminate\Http\Request;

class ParliamentMemberController extends Controller
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
        //
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
            !isset($request->first_name)
            || !isset($request->last_name)
            || !isset($request->party)
        ) {
            return response()->json(
                ['error' => 'missing data']
            );
        }

        $parliamentMember = new ParliamentMember();
        $parliamentMember->first_name = $request->first_name ?? null;
        $parliamentMember->last_name = $request->last_name ?? null;
        $parliamentMember->party = $request->party ?? null;

        if (!$parliamentMember->save()) {
            return response()->json(
                ['error' => 'something went wrong saving parliament member']
            );
        }

        return response()->json(
            [
                'status' => true,
                'data' => [
                    'par$parliamentMember' => $parliamentMember,
                ],
            ]
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ParliamentMember  $parliamentMember
     * @return \Illuminate\Http\Response
     */
    public function show(ParliamentMember $parliamentMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ParliamentMember  $parliamentMember
     * @return \Illuminate\Http\Response
     */
    public function edit(ParliamentMember $parliamentMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ParliamentMember  $parliamentMember
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ParliamentMember $parliamentMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ParliamentMember  $parliamentMember
     * @return \Illuminate\Http\Response
     */
    public function destroy(ParliamentMember $parliamentMember)
    {
        //
    }
}

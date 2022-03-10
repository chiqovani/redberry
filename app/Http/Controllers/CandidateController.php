<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateRequest;
use App\Http\Requests\CandidateUpdateRequest;
use App\Models\Candidates;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Candidates $candidate)
    {
        if($request->has('status')) {
            return $candidate->getCandidatesByStatusId(intval($request->get('status')));
        }
        return $candidate->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CandidateRequest $request, Candidates $candidate)
    {
        $params = $request->validated();
        return $candidate->create($params);
    }

    /**
     * Display the specified resource.
     *
     * @param Candidates $candidate
     * @return Candidates
     */
    public function show(Candidates $candidate)
    {
       return $candidate;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CandidateUpdateRequest $request
     * @param Candidates $candidate
     * @return Candidates
     */
    public function update(CandidateUpdateRequest $request, Candidates $candidate)
    {
        $candidate->update($request->validated());
        return $candidate;
    }

    /**
     * Remove the specified resource from storage
     *
     * @param Candidates $candidate
     * @return array
     */
    public function destroy(Candidates $candidate)
    {
        $candidate->delete();
        return [];
    }

    public function uploadCV(Request $request) {
        dd('uploading cv');
    }
}

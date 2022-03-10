<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateUpdateRequest;
use App\Models\Candidates;
use App\Models\Status;
use App\Models\StatusChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

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
     * @param Request $request
     * @param Candidates $candidate
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function store(Request $request, Candidates $candidate)
    {
        $path = storage_path('app/public/');
        try {
            $validator = Validator::make($request->all(), $this->getRules());
            $params = $validator->validated();
            if($request->has('cv')) {
                $file = $params['cv'];
                $fileName = md5(Str::random()) . '.' .$file->getClientOriginalExtension();
                $file->move($path, $fileName);
                $params['cv'] = $fileName;
            }
            $params['status_id'] = Status::where('name', 'Initial')->first()->id;
            return $candidate->create($params);
        }
        catch(ValidationException $exception) {
            return response(['status' => 'error', 'message' => 'validation failed', 'data' => $exception->errors()], 400);
        }
        catch(\Throwable $exception) {
            return response(['status' => 'error', 'message' => 'internal server error', 'data' => $exception->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Candidates $candidate
     * @return Candidates
     */
    public function show(Candidates $candidate)
    {
       return $candidate->load('statusChangeTimeline');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Candidates $candidate
     * @return Candidates
     */
    public function update(Request $request, Candidates $candidate)
    {
        try {
            $validator = Validator::make($request->all(), $this->getUpdateRules());
            $params = $validator->validated();
            $comment = null;
            if(isset($params['status_comment'])) {
                $comment = $params['status_comment'];
                unset($params['status_comment']);
            }
            $data = ['status_id' => $params['status_id'], 'comment' => $comment,'candidate_id' => $candidate->id];
            StatusChange::create($data);
            $candidate->update($params);
            return $candidate;
        }
        catch(ValidationException $exception) {
            return response(['status' => 'error', 'message' => 'validation failed', 'data' => $exception->errors()], 400);
        }
        catch(\Throwable $exception) {
            return response(['status' => 'error', 'message' => 'internal server error', 'data' => $exception->getMessage()], 500);
        }
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

    protected function getRules()
    {
        return  [
            'first_name'=>'required|string',
            'last_name'=>'required|string',
            'position'=>'required|string',
            'min_salary'=> 'sometimes|integer',
            'max_salary'=> 'sometimes|integer',
            'linkedin_url'=> 'sometimes|string',
            'cv' => 'sometimes|mimes:jpeg,png,doc,docs,pdf'
        ];
    }

    protected function getUpdateRules()
    {
        return [
            'status_id'=> 'required|integer|exists:statuses,id',
            'status_comment' => 'exclude_without:status_id|string'
        ];
    }
}

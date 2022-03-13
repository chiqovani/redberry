<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidateUpdateRequest;
use App\Models\Candidates;
use App\Models\Status;
use App\Models\StatusChange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        if($request->has('status') && $request->get('status') != null) {
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
       return $candidate->load('statusChangeTimeline')->load('tags');;
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
            DB::transaction(function () use ($params,$candidate) { // Start the transaction
                $comment = null;
                if(key_exists('add_tag',$params)) {
                    $candidate->attachTags([$params['add_tag']]);
                    unset($params['add_tag']);
                }

                if(key_exists('remove_tag',$params)) {
                    $candidate->detachTags([$params['remove_tag']]);
                    unset($params['remove_tag']);
                }
                if(key_exists('status_comment', $params)) {
                    $comment = $params['status_comment'];
                    unset($params['status_comment']);
                }
                if(isset($params['status_id'])) {
                    $data = ['status_id' => $params['status_id'], 'comment' => $comment,'candidate_id' => $candidate->id];
                    StatusChange::create($data);
                }
                $candidate->update($params);
                $candidate->refresh();
            });
            return $candidate->load('tags');
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
            'min_salary'=> 'sometimes|numeric',
            'max_salary'=> 'sometimes|numeric',
            'linkedin_url'=> 'sometimes|string',
            'cv' => 'sometimes|mimes:jpeg,png,doc,docs,pdf'
        ];
    }

    protected function getUpdateRules()
    {
        return [
            'first_name'=>'sometimes|string',
            'last_name'=>'sometimes|string',
            'position'=>'sometimes|string',
            'min_salary'=> 'sometimes|numeric',
            'max_salary'=> 'sometimes|numeric',
            'linkedin'=> 'sometimes|string',
            'status_id'=> 'sometimes|integer|exists:statuses,id',
            'status_comment' => 'exclude_without:status_id',
            'add_tag' => 'sometimes',
            'remove_tag' => 'sometimes'
        ];
    }
}

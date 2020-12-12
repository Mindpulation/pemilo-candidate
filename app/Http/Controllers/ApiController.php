<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CandidateModel;

class ApiController extends Controller
{
    public function index(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        $model = new CandidateModel;

        $result = $model->getCandidate($content);

        return response()->json($result, 200);
        // return response()->json(CandidateModel::all(), 200);
    }

    public function shows(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        $model = new CandidateModel;

        $result = $model->getCandidate($content);

        return response()->json($result, 200);
    }

    public function create(Request $request)
    {


        // $content = json_decode(file_get_contents('php://input'), true);
        $content = json_decode($request->getContent(), true);

        $model = new CandidateModel;

        $id = $model->candidateIdGenerate($content['codeRoom']);
        $misi = implode(',', $content['mission']);

        // $this->validate($content, [
        //     'codeRoom' => 'required',
        //     'candidateName' => 'required',
        //     'position' => 'required'
        // ]);

        $data = [
            'id' => $id,
            'room__id' => $content['codeRoom'],
            'name' => $content['candidateName'],
            'photo' => $content['linkPhoto'],
            'vision' => $content['visi'],
            'mission' => '{' . $misi . '}',
            'position' => $content['position'],
            'classroom' => $content['classroom']
        ];

        $result = $model->insert($data);

        $return_value = response([
            'status' => 'ok',
            'message' => 'successfully added new data!'
        ], 201);

        if (!$result) {
            $return_value = response([
                'status' => 'error',
                'message' => 'Error when try save data to database!'
            ], 500);
        }

        return $return_value;
    }

    public function room(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        $model = new CandidateModel;

        $room_id = $content['room__id'];

        $result = $model->getPosition($room_id);

        return $result;
    }

    public function update(Request $request)
    {
        $content = json_decode($request->getContent(), true);

        $id = $content['id'];

        $check_candidate = CandidateModel::firstWhere('id', $id);
        if (!$check_candidate) {
            return response([
                'status' => 'Not Found',
                'message' => 'Candidate with id ' . $id . ' Not Found!'
            ], 404);
            exit;
        }
        $model = new CandidateModel;

        $misi = implode(',', $content['mission']);

        // $this->validate($content, [
        //     'codeRoom' => 'required',
        //     'candidateName' => 'required',
        //     'position' => 'required'
        // ]);

        $data = [
            'room__id' => $content['codeRoom'],
            'name' => $content['candidateName'],
            'photo' => $content['linkPhoto'],
            'vision' => $content['visi'],
            'mission' => '{' . $misi . '}',
            'position' => $content['position'],
            'classroom' => $content['classroom']
        ];

        $update = $model->edit($data, $id);

        $return_value = response([
            'status' => 'ok',
            'message' => 'Successfully update the data!'
        ], 200);

        if (!$update) {
            $return_value = response([
                'status' => 'ok',
                'message' => 'Error when update data to database!'
            ], 500);
        }

        return $return_value;
    }

    public function drop(Request $request)
    {

        $content = json_decode($request->getContent(), true);
        print_r($content); rxit;
        $id = $content['id'];
        $check_candidate = CandidateModel::firstWhere('id', $id);
        $model = new CandidateModel;

        if (!$check_candidate) {
            return response([
                'status' => 'Not Found',
                'message' => 'Candidate with id ' . $id . ' Not Found'
            ], 404);
            exit;
        }

        $query = CandidateModel::destroy($id);

        if ($query) {
            $return_value = response([
                'status' => 'ok',
                'message' => 'Successfully delete the data!'
            ], 200);
        } else {
            $return_value = response([
                'status' => 'error',
                'message' => 'Error when delete data in database!'
            ], 500);
        }

        return $return_value;
    }
}

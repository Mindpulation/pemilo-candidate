<?php

namespace App\Models;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CandidateModel extends Model
{
    protected $table = 'candidate';
    protected $primaryKey = 'id';
    use HasFactory;

    public function candidateIdGenerate($prm_room)
    {
        $query = DB::select("select count(*) from candidate where room__id = '$prm_room'");

        $front = date('ym');
        $back = '00';
        $result = $query[0]->count + 1;
        if ($query[0]->count >= 10) {
            $back = '0';
        } else if ($query[0]->count >= 100) {
            $back = '';
        }

        $return_value = $front . $prm_room . $back . $result;
        return $return_value;
    }

    public function insert($data)
    {
        $query = DB::table($this->table)->insert($data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }

    public function edit($data, $prm_id)
    {
        $query = DB::table($this->table)->where('id', $prm_id)->update($data);

        if ($query) {
            return true;
        } else {
            return false;
        }
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MarcacionStore;
use App\Http\Resources\MarcacionResource;
use App\Models\Marcacion;
use Illuminate\Http\Request;
use App\Models\DepartmentHour;
use App\Traits\ResponseTrait;

class MarcacionesController extends Controller
{
    use ResponseTrait;
    public function index(Request $request){
        $user = $request->user();
        $marcaciones = Marcacion::hasUser($user->id);
        foreach($request->input('filters',[]) as $key => $value){
            $marcaciones->{$key}($value);
        }
        $marcaciones = $marcaciones->get();
        return MarcacionResource::collection($marcaciones);
    }

    public function store(MarcacionStore $request){
        $params = $request->validated();
        $marcacionAnterior = Marcacion::whereDate("datetime",now())->where("user_id", $request->user()->id)->first();
        $type = "in";
        if(!empty($marcacionAnterior)){
            if($marcacionAnterior->type == "in"){
                $type = "out";
            }else if($marcacionAnterior->type == "out"){
                $type = "in";
            }
        }
        $user = $request->user();
        $horaPorMarcar = "";
        if(!empty($user->department_id)){
            $departmentsHour = DepartmentHour::where(["department_id" => $user->department_id])
            ->where(["day" => date("w")])->first();
            $timeIn = now()->diff(now()->setTimeFromTimeString($departmentsHour->init));
            $timeOut = now()->diff(now()->setTimeFromTimeString($departmentsHour->end));
            $timeMinutesIn = ($timeIn->i + ($timeIn->h * 60)) * (empty($timeIn->invert) ? 1 : -1);
            $timeMinutesOut = ($timeOut->i + ($timeOut->h * 60)) * (empty($timeOut->invert) ? 1 : -1);
            if($timeMinutesIn < $timeMinutesOut){
                $horaPorMarcar = $departmentsHour->init;
                if(!empty($marcacionAnterior) && $marcacionAnterior->type == "in"){
                    $horaPorMarcar = "";
                }
            }else{
                $horaPorMarcar = $departmentsHour->end;
            }
        }
        $overdueTime = "";
        if(!empty($horaPorMarcar)){
            $timeMarcacion = now()->setTimeFromTimeString($horaPorMarcar);
            $diffMarcacion = now()->diff($timeMarcacion);
            if(!empty($diffMarcacion->invert)){
                $overdueTime = "{$diffMarcacion->h}:{$diffMarcacion->i}:{$diffMarcacion->s}";
            }
        }
        $marcacion = Marcacion::create([
            "user_id" => $request->user()->id,
            "position" => $params["position"],
            "type" => $type,
            "overtime" => $overdueTime,
            "datetime" => now(),
        ]);
        return new MarcacionResource($marcacion);
    }
}

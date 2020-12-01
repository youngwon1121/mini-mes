<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProcessStore;
use App\Http\Requests\ProcessSetFlow;
use App\Models\Process;

class ProcessController extends Controller
{
    public function store(ProcessStore $request)
    {
        $process = Process::create(['name' => $request->name]);
        $response = [
            'message' => 'success',
            'data' => $process->toArray()
        ];
        return response($response, 201);
    }

    public function index()
    {
        $processes = Process::all();
        $response = [
            'data' => $processes
        ];
        return $response;
    }

    public function setFlow(ProcessSetFlow $request, Process $process)
    {
        $process->next = $request->next;
        $process->save();

        return ['message' => 'success'];
    }
}

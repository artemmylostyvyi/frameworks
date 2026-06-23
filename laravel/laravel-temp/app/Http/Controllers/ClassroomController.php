<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClassroomController extends Controller
{

    private string $file;


    public function __construct()
    {
        $this->file = storage_path('app/classrooms.json');
    }


    public function index()
    {
        return response()->json($this->readData());
    }



    public function show($id)
    {
        $classrooms = $this->readData();


        foreach ($classrooms as $classroom) {

            if ($classroom['id'] == $id) {

                return response()->json($classroom);

            }
        }


        return response()->json([
            'message'=>'Classroom not found'
        ],404);
    }



    public function store(Request $request)
    {

        $classrooms = $this->readData();


        $new = [
            'id'=>(string)(count($classrooms)+1),
            'number'=>$request->number,
            'building'=>$request->building,
            'capacity'=>$request->capacity,
            'type'=>$request->type,
            'is_available'=>$request->is_available
        ];


        $classrooms[]=$new;


        $this->writeData($classrooms);


        return response()->json($new,201);

    }




    public function update(Request $request,$id)
    {

        $classrooms=$this->readData();


        foreach($classrooms as &$classroom){

            if($classroom['id']==$id){


                foreach($request->all() as $key=>$value){

                    $classroom[$key]=$value;

                }


                $this->writeData($classrooms);


                return response()->json($classroom);

            }

        }


        return response()->json([
            'message'=>'Classroom not found'
        ],404);

    }




    public function destroy($id)
    {

        $classrooms=$this->readData();


        foreach($classrooms as $key=>$classroom){


            if($classroom['id']==$id){


                unset($classrooms[$key]);


                $this->writeData(array_values($classrooms));


                return response()->json(null,204);

            }
        }


        return response()->json([
            'message'=>'Classroom not found'
        ],404);

    }





    private function readData()
    {
        return json_decode(
            file_get_contents($this->file),
            true
        );
    }



    private function writeData($data)
    {
        file_put_contents(
            $this->file,
            json_encode($data,JSON_PRETTY_PRINT)
        );
    }

}

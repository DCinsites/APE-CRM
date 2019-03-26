<?php
namespace App\Http\Controllers;


use App\TicketStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class TicketStatusController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return  \Illuminate\Http\Response
     */
    function index()
    {
        return view('support.status');
    }


    function paginate()
    {

        $query_key = Input::get('search');
        $search_key        = $query_key['value'];
        $number_of_records = TicketStatus::all()->count();


        $query = TicketStatus::orderBy('sequence_number', 'ASC');


        if($search_key)
        {
            $query->where('name', 'like', $search_key.'%') ;
        }

        $recordsFiltered = $query->get()->count();
        $query->skip(Input::get('start'))->take(Input::get('length'));
        $data = $query->get();

        $rec = [];

        if (count($data) > 0)
        {
            foreach ($data as $key => $row)
            {

                $rec[] = array(
                    a_links('<a class="edit_item" data-id="'.$row->id.'" href="#">'.$row->name.'</a>' , []),
                    $row->sequence_number,
                    side_by_side_links($row->id, route('delete_ticket_status', $row->id) )

                );

            }
        }


        $output = array(
            "draw" => intval(Input::get('draw')),
            "recordsTotal" => $number_of_records,
            "recordsFiltered" => $recordsFiltered,
            "data" => $rec
        );


        return response()->json($output);


    }


    /**
     * Store a newly created resource in storage.
     *
     * @param    \Illuminate\Http\Request  $request
     * @return  \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'                      =>  'required|unique:ticket_statuses' ,
            'sequence_number'			=> 'nullable|integer'      

        ]);

        if ($validator->fails()) 
        {
            return response()->json(['status' => 2 ,'errors'=>$validator->errors()]);
        }

        // Saving Data
        TicketStatus::create($request->all());

        return response()->json(['status' => 1]);
    }

    public function edit(Request $request)
    {
        $obj = TicketStatus::find(Input::get('id'));

        if($obj)
        {
            return response()->json(['status' => 1, 'data' => $obj->toArray()]);
        }
        else
        {
            return response()->json(['status' => 2 ]);
        }

    }


    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id'                =>  'required',
            'sequence_number'			=> 'nullable|integer',  
            'name' => [
                'required',
                Rule::unique('ticket_statuses')->ignore($request->id),
            ],
        ]);

        if ($validator->fails()) 
        {
            return response()->json(['status' => 2 ,'errors'=>$validator->errors()]);
        }

        // Saving Data
        $obj = TicketStatus::find(Input::get('id'));        
        $obj->update(Input::all());   

        return response()->json(['status' => 1]);

    }

    function destroy(TicketStatus $obj)
    {
        try {                 

             $obj->delete();
             session()->flash('message', __('form.success_delete'));

        } catch (\Illuminate\Database\QueryException $e) {
           
            session()->flash('message', __('form.delete_not_possible_fk'));
        }
        catch (\Exception  $e) {            
           
            session()->flash('message', __('form.could_not_perform_the_requested_action'));                        
        }

        return redirect()->back();
    }

}

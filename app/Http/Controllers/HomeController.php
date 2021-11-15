<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Helpers\ImageResizeHelper;
use Session;
use Validator;
use Image;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $properties = DB::table('properties')->paginate(15);

        return view('welcome' ,['properties' => $properties]);
    }

    public function deleteProperty(Request $request)
    {
        if (empty($request->ids)) return  response()->json(['status'=>1, 'msg'=>"please select a  property to delete"]);;

        $deleted = DB::table('properties')->where('id', $request->ids)->delete();

        if ($deleted) return response()->json(['status'=>0, 'msg'=>"the selected properties have been successfully deleted"]);
    }

    public function searchProperty(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'searchWord'=>'regex:/(^[A-Za-z0-9 ]+$)+/|max:125',
        ]);

        if(!$validator->passes()) return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);

        if (is_int($request->get('query'))) {
            $data = DB::table('properties')
                        ->where(trim($request->get('searchCriteria')), trim($request->get('query')))
                        ->orderBy('id', 'desc')
                        ->get();
         }

        $data = DB::table('properties')
                        ->where(trim($request->get('searchCriteria')), 'like', '%'.trim($request->get('query')).'%')
                        ->orderBy('id', 'desc')
                        ->get();

        return json_encode($data);
    }

    public function addProperty(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'county'=>'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:125',
            'country'=>'required|max:125',
            'town'=>'required|regex:/(^[A-Za-z0-9 ]+$)+/',
            'address'=>'required',
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description'=>'required|min:5|max:1000',
            'price'=>'required',
        ]);

        if(!$validator->passes()) return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);

        $image = $request->file('image');

        $imageName = ImageResizeHelper::instance()->resizeAndSave($image);//instance of custom helper class - see namespace

        $values = [
            'county'=> trim(htmlspecialchars($request->county)),
            'country' => trim(htmlspecialchars($request->country)),
            'town'=> trim(htmlspecialchars($request->town)),
            'description' => trim(htmlspecialchars($request->description)),
            'price' => trim(htmlspecialchars($request->price)),
            'displayableAddress'=> trim(htmlspecialchars($request->address)),
            'image'=> config('myconfig.config.server_url')."images/$imageName",
            'thumbnail' => config('myconfig.config.server_url')."thumbnail/$imageName",
            'numberofBedrooms'=> trim(htmlspecialchars($request->bedrooms)),
            'numberofBathrooms'=> trim(htmlspecialchars($request->bathrooms)),
            'propertyTypeId'=> trim(htmlspecialchars($request->type)),
            'forSaleOrRent'=> trim(htmlspecialchars($request->saleOrRent)),
        ];

        $query = DB::table('properties')->insert($values);
        if( $query ) return response()->json(['status'=>1, 'msg'=>'New property has been successfully registered']);
    }

    public function editProperty(Request $request, $id)
    {
        if($request->ajax())
        {
            $data = DB::table('properties')->where('id' , $id)->get();
            return json_encode($data);
        }
    }

    public function updateProperty(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            'editCounty'=>'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:125',
            'editCountry'=>'required|max:125',
            'editTown'=>'required|regex:/(^[A-Za-z0-9 ]+$)+/',
            'editAddress'=>'required',
            'editImage'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'editDescription'=>'required|min:5|max:1000',
            'editPrice'=>'required',
        ]);

        if(!$validator->passes()) return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);

        $image = $request->file('editImage');

        $imageName = ImageResizeHelper::instance()->resizeAndSave($image);

        $values = [
            'county'=> trim(htmlspecialchars($request->editCounty)),
            'country' => trim(htmlspecialchars($request->editCountry)),
            'town'=> trim(htmlspecialchars($request->editTown)),
            'description' => trim(htmlspecialchars($request->editDescription)),
            'price' => trim(htmlspecialchars($request->editPrice)),
            'displayableAddress'=> trim(htmlspecialchars($request->editAddress)),
            'image'=> config('myconfig.config.server_url')."images/$imageName",
            'thumbnail' => config('myconfig.config.server_url')."thumbnail/$imageName",
            'numberofBedrooms'=> trim(htmlspecialchars($request->editBedrooms)),
            'numberofBathrooms'=> trim(htmlspecialchars($request->editBathrooms)),
            'propertyTypeId'=> trim(htmlspecialchars($request->editType)),
            'forSaleOrRent'=> trim(htmlspecialchars($request->editSaleOrRent)),
        ];
        
        $updated = DB::table('properties')->where('id', $id)->update($values);

        if( $updated ) return response()->json(['status'=>1, 'msg'=>'New property has been successfully Updated']);
    }

    public function fetchAutoComplete(Request $request)
    {
        if($request->get('query'))
        {
            $validator = Validator::make($request->all(),[
                'query'=>'required|regex:/(^[A-Za-z0-9 ]+$)+/|max:125',
            ]);
    
            if(!$validator->passes()) return response()->json(['status'=>0, 'error'=>$validator->errors()->toArray()]);

            $data = DB::table('properties')
                ->where('displayableAddress', 'LIKE', "%{$request->get('query')}%")
                ->get();
            
            if ($request->get('searchCriteria') == "location") {
                $data = DB::table('properties')
                ->where('country', 'LIKE', "%{$request->get('query')}%")
                ->get();
            }

            $output = '<ul class="dropdown-menu" style="display:block; position:relative">';

            foreach ($data as $row)
            {
                $output .= '<li><a href="#">'.$row->displayableAddress.'</a></li>';
            }

            $output .= '</ul>';
            echo $output;
        }
    }
}

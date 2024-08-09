<?php

namespace App\Http\Controllers\Ecom\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Helpers\Convert;
use Illuminate\Support\Facades\Storage;

use DB;
use DataTables;
use Carbon\Carbon;
use Image;

use App\Models\PoinStrukOffline;

class StrukBelanjaOfflineController extends Controller
{
    public function index($id, $tipe_customer){
        return view('ecom.profile.profile-struk-belanja-offline');
    }

    public function store(request $request){
        $array_validation = [
            'nominal_belanja' => 'required',
            'upload_image' => 'required|mimes:jpg,png,jpeg|max:10048',
        ];

        $validator = Validator::make($request->all(), $array_validation);

		if($validator->fails()) {
			return [
				'status' => 300,
				'message' => $validator->errors()->first()
			];
		}

        if(!empty($request->file('upload_image'))){
            $file = $request->file('upload_image');

            $name_image =  md5(time()."_".$file->getClientOriginalName()).".".$file->getClientOriginalExtension();

            $img = Image::make($file);
            // $img->rotate(-90);
            $img->resize(650, null, function ($constraint) {
                $constraint->aspectRatio();
            });

            //detach method is the key! Hours to find it... :/
            $resource = $img->stream()->detach();

            Storage::disk('s3')->put('struk-belanja-offline/' . $name_image, $resource);

            $request->request->add(['url_image' => 'https://'. env('AWS_BUCKET') .'.s3.'. env('AWS_DEFAULT_REGION') .'.amazonaws.com/struk-belanja-offline/' . $name_image]);
        }

        // if(!empty($request->file('upload_image'))){
        //     $file = $request->file('upload_image');

        //     $place_image = 'berkas/struk-belanja-offline/';
        //     $name_image =  md5(time()."_".$file->getClientOriginalName()).".".$file->getClientOriginalExtension();

        //     $file->move($place_image, $name_image);
        //     $database_file = $place_image . $name_image;

        //     $request->request->add(['url_image' => $database_file]);
        // }

        $request->request->add(['user_id' => auth()->user()->id]);
        $request->merge(['nominal_belanja' => Convert::convert_to_number($request->nominal_belanja) ]);

        PoinStrukOffline::create($request->all());

        return [
            'status' => 201,
            'link' => '/profile',
            'message' => 'Struk berhasil diupload untuk admin review'
        ];
    }
}

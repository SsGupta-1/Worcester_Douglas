<?php

namespace App\Http\Controllers\Admin\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Tutorial;
use Toastr;

class TutorialController extends Controller
{
    public function index()
    {
       $tutorial_1 = Tutorial::where('screen_type','1')->first();
       $tutorial_2 = Tutorial::where('screen_type','2')->first();
       //dd($tutorial_1->mimeType);
        return view('admin.tutorial.index', compact('tutorial_1','tutorial_2'));
    }

    public function add(Request $request)
    {

       
        if(Tutorial::count() > 1){
            $input = $request->all();
            
            for($i = 0; $i < count($request->screen); $i++){
                    $update = Tutorial::where('id', '=', $input['id'][$i])->first();
                    
                    $update->screen_type   = $input['screen'][$i];
                    $update->caption       = isset($input['caption'][$i]) ? $input['caption'][$i] : '';

                    $gettype  = isset($input['file'][$i]) ? $input['file'][$i]->getMimeType() : '';
                        if($gettype){
                            $type   =  $gettype;
                            $update->mimeType      = explode('/',$type)[0];
                        }
                    $update->file          = !empty($input['file'][$i]) ? $this->imageUpload($input['file'][$i],$input['oldFile'][$i]) : $input['oldFile'][$i];
                    $update->created_by    = auth()->user()->id;
                    
                    $result= $update->save();
                
            } 
        }else{
            $input = $request->all();
            for($i = 0; $i < count($request->screen); $i++){
                
                $type = isset($input['file'][$i]) ? $input['file'][$i]->getMimeType(): '';
                $data[] = [
                    'screen_type' => $input['screen'][$i],
                    'caption'     => isset($input['caption'][$i]) ? $input['caption'][$i] : '',
                    'mimeType'    => explode('/',$type)[0],
                    'file'        => isset($input['file'][$i]) ? $this->imageUpload($input['file'][$i]) : '',
                    'created_by'  => auth()->user()->id,
                    'created_at'  => date('Y-m-d H:i:s'),
                ];
                      
            }
            
            $result = Tutorial::insert($data);
           
        }
        if($result){
            Toastr::success('Tutorial Updated Successfully', 'Success', ['timeOut' => 5000]);
            return redirect('admin/manage-tutorial');
        }else{
            Toastr::error('Something wrong', 'Failed', ['timeOut' => 5000]);
        }
        
    }




    private function imageUpload($fileData, $oldFile= null){

        $fileName = time().rand(0,100).'.'.$fileData->extension();
        $fileData->move(public_path('file/admin/tutorial'), $fileName);
        if(!empty($oldFile)){
            $file_path = public_path().'/file/admin/tutorial/'.$oldFile;
            unlink($file_path);
        }
        $file = $fileName;
        return $file;
    }

    public function delete(Request $request){
         $tutorial = Tutorial::where('id', $request->id)->first();    
        // dd($tutorial->mimeType);
         if($tutorial){
           $tutorial->file = NULL;
           $tutorial->mimeType = NULL;
         }
         $tutorial->save();
         Toastr::success('Tutorial Deleted Successfully', 'Success', ['timeOut' => 5000]); 
         return redirect('admin/manage-tutorial');
 
     }
}



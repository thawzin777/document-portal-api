<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Api\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
class DocumentController extends BaseController
{
    //

    public function index(){
        $documents=DB::table('documents')
        ->join('users','documents.user_id','=','users.id')
        ->select('documents.id','documents.title','documents.file_path','users.name as user_name','documents.created_at','users.id as user_id')
        ->orderBy('created_at','desc')
        ->paginate(5);
        return response()->json($documents,200);
        // return $this->sendResponse($documents, 'Documents retrieved successfully.');
    }

    public function show($id){
        $document=DB::table('documents')->where('id',$id)->first();
        if($document){
           // return response()->json($document,200);
            return $this->sendResponse($document, "Document $id retrieved successfully.");
        }else{
           // return $this->sendError('Document not found');
           return $this->sendError('Document not found', [], 404);
        }
    }

    public function store(Request $request){
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'file' => [
                'required',
                'file',
                'mimes:pdf,doc,docx',
                'max:10240',
            ],
        ]);
         
        $existingDocument = DB::table('documents')->where('title', $validated['title'])->first();
        if ($existingDocument) {
            //return response()->json(['message' => 'Document with the same title already exists'], 400);
             return $this->sendError('Document with the same title already exists');
        }
        $filePath = $request->file('file')->store('documents', 'public');
        $documentId=DB::table('documents')->insertGetId([
            'title'=>$validated['title'],
            'file_path'=>$filePath,
            'user_id'=>Auth::id(),
            'created_at'=>now(),
            'updated_at'=>now(),
        ]);
       
        $document = DB::table('documents')
        ->where('id', $documentId)
        ->first();
        return $this->sendResponse($document, 'Document created successfully.');
    }

    public function destroy($id){
        $document=DB::table('documents')->where('id',$id)->first();
        if($document->user_id !== Auth::id()){
            return $this->sendError('You can only delete your own documents', [], 403);
        }
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }
        if($document){
            
            DB::table('documents')->where('id',$id)->delete();
            return $this->sendResponse(null, "Document $id deleted successfully.");
        }else{
            return $this->sendError('Document not found', [], 404);
        }
    }
}

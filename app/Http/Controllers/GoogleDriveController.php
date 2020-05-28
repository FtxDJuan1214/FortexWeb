<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Drive_DriveFile;

class GoogleDriveController extends Controller
{    
    private $drive;
    public function __construct(Google_Client $client)
    {
        $this->middleware(function($request ,$next) use ($client){
            //dd($client);
            //dd(Auth::user()->refresh_token);
            $client->refreshToken(Auth::user()->refresh_token);
            $this->drive = new Google_Service_Drive($client);
            return $next($request);
        });   
    }

    public function getFolders()
    {
        $this->ListFolders('1oQlxKvd9OkVwvb_tz7ru11So2P69C4RL');
        //$this->retrieveAllFiles('1SHHRWnU6XGJ_T8uMH5yo41WuTvSQNgZ1');
    }

    public function ListFolders($id){
        //$query = "mimeType='application/vnd.google-apps.folder' and '".$id."' in parents and trashed=false";Solo carpetas
       //dd($id);
        $historial =explode("||", $id);
        //print_r($historial);
        $lastId = explode(",",$historial[count($historial) -2])[1];
        $query = "'$lastId' in parents and trashed = false";
        //dd( $lastId);
        $optParams = [
            'fields' => 'files(id, name, modifiedTime, iconLink, webViewLink, webContentLink, mimeType)',
            'q' => $query
        ];

        $results = $this->drive->files->ListFiles($optParams);
        $list = $results->getFiles();
        //asort($list);
        print view('drive.index',compact('list','id','lastId'));
    }

    public function delteFile($parameter){

        $datos =explode("**", $parameter);
        $FileId = $datos[0];
        $FolderRoute = $datos[1];
        try {
			$this->drive->files->delete($FileId);
		} catch (Exception $e) {
			return redirect('/search')
				->with('message', [
					'type' => 'error',
					'text' => 'Something went wrong while trying to delete the file'
				]);
        }
        $redirect = '/api/'.$FolderRoute;
        return redirect( $redirect)
        ->with('message', [
            'type' => 'success',
            'text' => "File was deleted"
    ]);
    }
//     Consultar en todo el drive
//     function retrieveAllFiles($id) {
//         $result = array();
//         $pageToken = NULL;
//         $query = "mimeType='application/vnd.google-apps.file' and '".$id."' in parents and trashed=false";
//         do {
//           try {
//             $parameters = array();
//             if ($pageToken) {
//               $parameters = [
//                 'q' => $query,
//                 'orderBy' => 'modifiedTime',
//                 'pageToken' => $pageToken,
//                 'fields' => 'files(id, name, modifiedTime, iconLink, webViewLink, webContentLink)',
//             ];
//         }
//         $files = $this->drive->files->listFiles($parameters);
//         if (count($files->getFiles()) == 0) {
//           print "No files found.\n";
//       } else {
//           foreach ($files->getFiles() as $file) {
//               $res['name'] = $file->getName();
//               $res['id'] = $file->getId();
//               $files_ls[] = $res;
//           }
//           print_r($files_ls);
//       }
//             //$result = array_merge($result, $files->getItems());
//       $pageToken = $files->getNextPageToken();
//   } catch (Exception $e) {
//     print "An error occurred: " . $e->getMessage();
//     $pageToken = NULL;
// }
// } while ($pageToken);
// return $result;
// }


public function uploadFiles(Request $request)
{
    if($request->isMethod('GET')){
        return view('drive.upload');
    }else{
        if ($request->hasFile('file')) {

            $file = $request->file('file');

          $mime_type = $file->getMimeType();
          $title = $file->getClientOriginalName();
          $description = $request->input('description');

          $drive_file = new \Google_Service_Drive_DriveFile();
          $drive_file->setName($title);
          $drive_file->setDescription($description);
          $drive_file->setMimeType($mime_type);
          $drive_file->setParents([$request->input('folderid')]);

          try {
              $createdFile = $this->drive->files->create($drive_file, [
                  'data' => $file,
                  'mimeType' => $mime_type,
                  'uploadType' => 'multipart'
              ]);

              $file_id = $createdFile->getId();
              $redirect = '/api/'.$request->input('route');
              return redirect( $redirect)
                  ->with('message', [
                      'type' => 'success',
                      'text' => "File was uploaded with the following ID: {$file_id}"
              ]);

          } catch (Exception $e) {

              return redirect($redirect)
                  ->with('message', [
                      'type' => 'error',
                      'text' => 'An error occured while trying to upload the file'
                  ]);

          }
      }
    }
}
}

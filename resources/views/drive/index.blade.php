<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Laravel</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <!-- CSRF Token -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Styles -->
  <style>
    html, body {
      background-color: #fff;
      color: #636b6f;
      font-family: 'Nunito', sans-serif;
      font-weight: 200;
      height: 100vh;
      margin: 0;
    }

    .full-height {
      height: 100vh;
    }

    .flex-center {
      align-items: center;
      display: flex;
      justify-content: center;
    }

    .position-ref {
      position: relative;
    }

    .top-right {
      position: absolute;
      right: 10px;
      top: 18px;
    }

    .content {
      text-align: center;
    }

    .title {
      font-size: 84px;
    }

    .links > a {
      color: #636b6f;
      padding: 0 25px;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: .1rem;
      text-decoration: none;
      text-transform: uppercase;
    }

    .m-b-md {
      margin-bottom: 30px;
    }
  </style>
</head>
<body>
  <div class="flex-center position-ref full-height">
    @if (Route::has('login'))
    <div class="top-right links">
      @auth
      <a href="{{ url('/home') }}">Home</a>
      @else
      <a href="{{ route('login') }}">Login</a>

      @if (Route::has('register'))
      <a href="{{ route('register') }}">Register</a>
      @endif
      @endauth
    </div>
    @endif

    <div class="content">
      <div class="title m-b-md">
        {{ Auth::user()->name }}
      </div>

      <div class="row">
        <?php
        $carpetas = explode("||",$id);
        $history =''; 
        $lastName = '';
        for($i=0;$i<count($carpetas)-1; $i++){
        $history = $history.$carpetas[$i].'||';
        $item = explode(",", $carpetas[$i]);
        ?>
        <a href="{{ route('Gapi', $history) }}">{{strtoupper($item[0])}}</a><p> > </p>
        <?php
        $lastName = $item[0];
      }
      ?>
      <table class="table table-light">
        <thead>
          <tr>
            <th style="width = 30px;"></th>
            <th scope="col">Item Name</th>
            <th></th>
            <th></th>
            <th scope="col">Last Modification</th>
          </tr>
        </thead>
        <tbody>
         @foreach($list as $file)
         <tr>
           <td style="width = 30px;" ><img src="{{$file->iconLink }}"></td>
           @if($file->mimeType == "application/vnd.google-apps.folder")
           <?php $nid = $id.$file->name.','.$file->id.'||';?>
           <td><a href="{{ route('Gapi', $nid) }}">{{$file->name}}</a></td>
           <td></td>
           <td></td>
           @else
           <td><a href="{{$file->webViewLink}}" target="_blank">{{$file->name}}</a></td>
           <?php $varborrar = $file->id.'**'.$history?>
           <td><a href="{{ route('Delete', $varborrar) }}"><i class="fa fa-remove" aria-hidden="true"></i></a></td>
           <td><a href="{{$file->webContentLink}}"><i class="fa fa-download" aria-hidden="true"></i></a></td>
           @endif
           <td> {{ explode("T",$file->modifiedTime)[0]}}</td>
         </tr>
         @endforeach
       </tbody>
     </table>           

   </div>
   <div class="row">
    <div class="float-md-left" style="margin-top: 5px;">
      <a class="btn btn-primary btn-sm text-white" data-toggle="modal" data-target="#ModalUploas">
        Upload files
      </a>
    </div>
  </div>
  <!-- <div class="row">Id de la carpeta actual: {{$lastId}}</div>
  <div class="row">Totla items: {{count($list)}}</div> -->
  <!-- Modal -->
  <div class="modal fade" id="ModalUploas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Folder : {{$lastName}}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <h3>Upload Files</h3>
          <form method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="row">
              <label for="file">File</label>
              <input type="file" name="file" id="file">
            </div>
            <div class="row">
              <label for="description">Description</label>
              <input type="text" name="description" id="description">
            </div>
            <div class="row">
              <input type="hidden" name="folderid" id="folderid" value="{{$lastId}}">
              <input type="hidden" name="route" id="route" value="{{$id}}">
            </div>
            <button class="btn btn-primary">Upload</button>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</body>
</html>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
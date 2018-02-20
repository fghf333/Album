<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//HOME
Route::get('/', ['as' => 'home', 'uses' => 'HomeController@getHome']);

//UPLOADING
Route::get('upload/{AlbumID?}', ['as' => 'upload_form', 'uses' => 'UploadController@getForm']);
Route::post('upload', ['as' => 'upload_file', 'uses' => 'UploadController@upload']);

//IMAGE EDITOR
Route::get('edit-image/{imageID}', ['as' => 'edit_image_form', 'uses' => 'EditImageController@getForm']);
Route::post('edit-image/{imageID}', ['as' => 'edit_image', 'uses' => 'EditImageController@saveForm']);
Route::delete('delete-image/{imageID}', ['as' => 'delete_image', 'uses' => 'EditImageController@deleteImage']);

//ALBUM
Route::get('albums', ['as' => 'album_form', 'uses' => 'AlbumController@getList']);
Route::get('edit-album/{AlbumID}', ['as' => 'edit_album_form', 'uses' => 'AlbumController@getEditForm']);
Route::post('edit-album/{AlbumID}', ['as' => 'edit_album', 'uses' => 'AlbumController@editAlbum']);
Route::get('create-album', ['as' => 'create_album_form', 'uses' => 'AlbumController@getForm']);
Route::post('create-album', ['as' => 'create_album', 'uses' => 'AlbumController@createAlbum']);
Route::delete('delete-album/{AlbumID}', ['as' => 'delete_album', 'uses' => 'AlbumController@deleteAlbum']);


//LIST OF IMAGES
Route::get('images-list/{AlbumID?}', ['as' => 'images-list', 'uses' => 'ImagesListController@getList']);

//TEST ROUTE
Route::get('test', ['as' => 'test_form', 'uses' => 'TestController@test']);
Route::post('test', ['as' => 'test_upload', 'uses' => 'TestController@upload']);

// Authentication Routes...
Route::get('login', ['as' => 'login', 'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login', ['as' => '', 'uses' => 'Auth\LoginController@login']);
Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

// Password Reset Routes...
Route::post('password/email', ['as' => 'password.email', 'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail']);
Route::get('password/reset', ['as' => 'password.request', 'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm']);
Route::post('password/reset', ['as' => '', 'uses' => 'Auth\ResetPasswordController@reset']);
Route::get('password/reset/{token}', ['as' => 'password.reset', 'uses' => 'Auth\ResetPasswordController@showResetForm']);

// Registration Routes...
Route::get('register', ['as' => 'register', 'uses' => 'Auth\RegisterController@showRegistrationForm']);
Route::post('register', ['as' => '', 'uses' => 'Auth\RegisterController@register']);























Route::get('put', function () {
    Storage::cloud()->put('test.txt', 'Hello World');
    return 'File was saved to Google Drive';
});

Route::get('put-existing', function () {
    $filename = 'laravel.png';
    $filePath = public_path($filename);
    $fileData = File::get($filePath);

    Storage::cloud()->put($filename, $fileData);
    return 'File was saved to Google Drive';
});

Route::get('list', function () {
    $dir = '/';
    $recursive = false; // Get subdirectories also?
    $contents = collect(Storage::cloud()->listContents($dir, $recursive));

    //return $contents->where('type', '=', 'dir'); // directories
    return $contents->where('type', '=', 'file'); // files
});

Route::get('list-folder-contents', function () {
    // The human readable folder name to get the contents of...
    // For simplicity, this folder is assumed to exist in the root directory.
    $folder = 'Test Dir';

    // Get root directory contents...
    $contents = collect(Storage::cloud()->listContents('/', false));

    // Find the folder you are looking for...
    $dir = $contents->where('type', '=', 'dir')
        ->where('filename', '=', $folder)
        ->first(); // There could be duplicate directory names!

    if (!$dir) {
        return 'No such folder!';
    }

    // Get the files inside the folder...
    $files = collect(Storage::cloud()->listContents($dir['path'], false))
        ->where('type', '=', 'file');

    return $files->mapWithKeys(function ($file) {
        $filename = $file['filename'] . '.' . $file['extension'];
        $path = $file['path'];

        // Use the path to download each file via a generated link..
        // Storage::cloud()->get($file['path']);

        return [$filename => $path];
    });
});

Route::get('get', function () {
    $filename = 'test.txt';

    $dir = '/';
    $recursive = false; // Get subdirectories also?
    $contents = collect(Storage::cloud()->listContents($dir, $recursive));

    $file = $contents
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
        ->first(); // there can be duplicate file names!

    //return $file; // array with file info

    $rawData = Storage::cloud()->get($file['path']);

    return response($rawData, 200)
        ->header('ContentType', $file['mimetype'])
        ->header('Content-Disposition', "attachment; filename='$filename'");
});

Route::get('put-get-stream', function () {
    // Use a stream to upload and download larger files
    // to avoid exceeding PHP's memory limit.

    // Thanks to @Arman8852's comment:
    // https://github.com/ivanvermeyen/laravel-google-drive-demo/issues/4#issuecomment-331625531
    // And this excellent explanation from Freek Van der Herten:
    // https://murze.be/2015/07/upload-large-files-to-s3-using-laravel-5/

    // Assume this is a large file...
    $filename = 'laravel.png';
    $filePath = public_path($filename);

    // Upload using a stream...
    Storage::cloud()->put($filename, fopen($filePath, 'r+'));

    // Get file listing...
    $dir = '/';
    $recursive = false; // Get subdirectories also?
    $contents = collect(Storage::cloud()->listContents($dir, $recursive));

    // Get file details...
    $file = $contents
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
        ->first(); // there can be duplicate file names!

    //return $file; // array with file info

    // Store the file locally...
    //$readStream = Storage::cloud()->getDriver()->readStream($file['path']);
    //$targetFile = storage_path("downloaded-{$filename}");
    //file_put_contents($targetFile, stream_get_contents($readStream), FILE_APPEND);

    // Stream the file to the browser...
    $readStream = Storage::cloud()->getDriver()->readStream($file['path']);

    return response()->stream(function () use ($readStream) {
        fpassthru($readStream);
    }, 200, [
        'Content-Type' => $file['mimetype'],
        //'Content-disposition' => 'attachment; filename="'.$filename.'"', // force download?
    ]);
});

Route::get('create-dir', function () {
    Storage::cloud()->makeDirectory('Test Dir');
    return 'Directory was created in Google Drive';
});

Route::get('put-in-dir', function () {
    $dir = '/';
    $recursive = false; // Get subdirectories also?
    $contents = collect(Storage::cloud()->listContents($dir, $recursive));

    $dir = $contents->where('type', '=', 'dir')
        ->where('filename', '=', 'Test Dir')
        ->first(); // There could be duplicate directory names!

    if (!$dir) {
        return 'Directory does not exist!';
    }

    Storage::cloud()->put($dir['path'] . '/test.txt', 'Hello World');

    return 'File was created in the sub directory in Google Drive';
});

Route::get('newest', function () {
    $filename = 'test.txt';

    Storage::cloud()->put($filename, \Carbon\Carbon::now()->toDateTimeString());

    $dir = '/';
    $recursive = false; // Get subdirectories also?

    $file = collect(Storage::cloud()->listContents($dir, $recursive))
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
        ->sortBy('timestamp')
        ->last();

    return Storage::cloud()->get($file['path']);
});

Route::get('delete', function () {
    $filename = 'laravel.png';

    // First we need to create a file to delete
    //Storage::cloud()->makeDirectory('Test Dir');

    // Now find that file and use its ID (path) to delete it
    $dir = '/';
    $recursive = false; // Get subdirectories also?
    $contents = collect(Storage::cloud()->listContents($dir, $recursive));

    $file = $contents
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
        ->first(); // there can be duplicate file names!

    Storage::cloud()->delete($file['path']);

    return 'File was deleted from Google Drive';
});

Route::get('delete-dir', function () {
    $directoryName = 'test';

    // First we need to create a directory to delete
    //Storage::cloud()->makeDirectory($directoryName);

    // Now find that directory and use its ID (path) to delete it
    $dir = '/';
    $recursive = false; // Get subdirectories also?
    $contents = collect(Storage::cloud()->listContents($dir, $recursive));

    $directory = $contents
        ->where('type', '=', 'dir')
        ->where('filename', '=', $directoryName)
        ->first(); // there can be duplicate file names!

    Storage::cloud()->deleteDirectory($directory['path']);

    return 'Directory was deleted from Google Drive';
});

Route::get('rename-dir', function () {
    $directoryName = 'test';

    // First we need to create a directory to rename
    Storage::cloud()->makeDirectory($directoryName);

    // Now find that directory and use its ID (path) to rename it
    $dir = '/';
    $recursive = false; // Get subdirectories also?
    $contents = collect(Storage::cloud()->listContents($dir, $recursive));

    $directory = $contents
        ->where('type', '=', 'dir')
        ->where('filename', '=', $directoryName)
        ->first(); // there can be duplicate file names!

    Storage::cloud()->move($directory['path'], 'new-test');

    return 'Directory was renamed in Google Drive';
});

Route::get('upload-file', function () {
    // Use a stream to upload and download larger files
    // to avoid exceeding PHP's memory limit.

    // Thanks to @Arman8852's comment:
    // https://github.com/ivanvermeyen/laravel-google-drive-demo/issues/4#issuecomment-331625531
    // And this excellent explanation from Freek Van der Herten:
    // https://murze.be/2015/07/upload-large-files-to-s3-using-laravel-5/

    // Assume this is a large file...
    $filename = 'img.jpg';
    $filePath = '/Users/yaroslavgraboveckiy/Documents/Images/' . $filename;

    // Upload using a stream...
    Storage::cloud()->put($filename, fopen($filePath, 'r+'));

    // Get file listing...
    $dir = '/';
    $recursive = false; // Get subdirectories also?
    $contents = collect(Storage::cloud()->listContents($dir, $recursive));

    // Get file details...
    $file = $contents
        ->where('type', '=', 'file')
        ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
        ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
        ->first(); // there can be duplicate file names!

    //return $file; // array with file info

    // Store the file locally...
    //$readStream = Storage::cloud()->getDriver()->readStream($file['path']);
    //$targetFile = storage_path("downloaded-{$filename}");
    //file_put_contents($targetFile, stream_get_contents($readStream), FILE_APPEND);

    // Stream the file to the browser...
    $readStream = Storage::cloud()->getDriver()->readStream($file['path']);

    return response()->stream(function () use ($readStream) {
        fpassthru($readStream);
    }, 200, [
        'Content-Type' => $file['mimetype'],
        //'Content-disposition' => 'attachment; filename="'.$filename.'"', // force download?
    ]);
});


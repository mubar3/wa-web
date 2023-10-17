<?php

namespace App\Http\Controllers;

use App\Models\Umum;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Image;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public $tipeid_umum=[1];
    public $jenis_umum='single'; //single or multiple
    // public $jenis_umum='multiple'; //single or multiple
    // random berapa detik kirim bulk wa
    public $random_bulk_time=60;
    public $random_bulk_time_to=300;
    public $domain_api='http://srv.geogiven.co.id:';
    public $domain_api_multiple='https://manager.waweb.geogiven.tech';

    public function getSql($builder){
        $addSlashes = str_replace('?', "'?'", $builder->toSql());
        return vsprintf(str_replace('?', '%s', $addSlashes), $builder->getBindings());
    }

    public function __construct()
    {
        // ini_set('max_execution_time', '300');
        // ubah timeout detik + 25 detik
        // set_time_limit(120);
    }

    public function deleteRouteNames($url) {
      $parsedUrl = parse_url($url);
    
      if (isset($parsedUrl['scheme']) && isset($parsedUrl['host'])) {
        $newUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'];
    
        if (isset($parsedUrl['port'])) {
          $newUrl .= ':' . $parsedUrl['port'];
        }
    
        return $newUrl;
      }
    
      return $url;
    }

    public function getFirstRouteFromURL($url) {
      $parsed_url = parse_url($url);
  
      // Check if the path is present in the parsed URL
      if (isset($parsed_url['path'])) {
          // Remove leading and trailing slashes (if any)
          $path = trim($parsed_url['path'], '/');
  
          // Explode the path into an array of segments
          $segments = explode('/', $path);
  
          // Return the first segment (route)
          if (!empty($segments)) {
              return $segments[0];
          }
      }
  
      // If no path or segments found, return an empty string
      return '';
    }
  
    function hasExtension($link) {
      $path_parts = pathinfo($link);
      
      if (isset($path_parts['extension'])) {
        // Link has an extension
        return true;
      } else {
        // Link does not have an extension
        return false;
      }
    }

    public function base64Image_link($mimetype,$base64,$destination,$namefile)
    {
        $file = base64_decode($base64);
        $extension = '.'.explode('/', $mimetype)[1];
        $ekstensi_json = json_decode(file_get_contents(public_path() . "/berkas/file-extension-to-mime-types.json"), true);
        foreach ($ekstensi_json as $key => $value) {
          if($value == $mimetype){
            $extension=$key;
          }
        }
        $namefile = $namefile.$extension;

        // Save the file
        file_put_contents($destination . '/' . $namefile, $file);
        
        return $namefile;
    }

    public function isNullOrEmpty($variable) {
        return ($variable === null || $variable === '');
    }

    public function formatNumber($number) {
      // Remove any non-numeric characters
      $number = preg_replace('/[^0-9]/', '', $number);
  
      // Check if the number starts with 0
      if (substr($number, 0, 1) === '0') {
          // Replace the leading 0 with 628
          $number = '62' . substr($number, 1);
      }
  
      return $number;
  }

  public function arrayToRequest(array $data)
  {
      // Create a new empty request instance
      $request = Request::create('', 'POST');

      // Set the data from the array to the request
      $request->merge($data);

      return $request;
  }
}

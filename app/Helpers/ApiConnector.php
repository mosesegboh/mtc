<?php
namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ApiConnector
{
    private $mtcApiurl;

	public function __construct()
    {
	}

    public function getData($mytcApiUrl)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $mytcApiUrl,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Cookie: XSRF-TOKEN=eyJpdiI6IjZHUmpGSFYrbU1iVjRYbVdIYjNnR3c9PSIsInZhbHVlIjoiNFwvcVhkSGYxUk1Xbkc5cWRFcXNaUkdSK2U2MWpwcjNzSWRjRUtYS1hGT3ZsTzhleVZpNGVLZTN6NVRjbzRnZmoiLCJtYWMiOiI4MzE4ZTg5YWRkMDBjNjAwYTRlNDg1N2RlYzkxNmEyN2M1OTgyYWNiZmViMjI2ODkzYjBmM2E0OTIyYjE5Zjc0In0%3D; laravel_session=eyJpdiI6ImplS0FyQkVQTEFQT1R5anhLQkJ3cUE9PSIsInZhbHVlIjoid3ZCblJ6MTNreThHYURHR3dGRXFSSHRWekdKUnl6WVU3dmorclpNdE5WTFdjSVhLZ1ZNQkpBT3BmQVUwa2hkbiIsIm1hYyI6IjEwYjI4NjE5OWFiZTllNjkzYjQxMWIyY2QzNTY0YzgwMmNmNDc3MWYxN2QxMDE4M2Q2ODNlNDZjNzg4MmEwMTYifQ%3D%3D'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $properties=json_decode($response,true);
        return $properties;
    }

    public function insertData($mytcApiUrl)
    {
        $x = 1;
        $propertiesData = $propertiesDataType = [];
        do {
                try{
                    $properties=$this->getData($mytcApiUrl);
                } catch( \Exception $e ) {
                    if ($e) {
						echo $e->getMessage();
                        die();
					}
                }

                if (empty($properties['data'])) {
                    echo 'Rate limit, trying again after 60 sec';
                    sleep(60);
                }
                 
                foreach ($properties['data'] as $key => $value) {
                    $preparedDataProperties = [
                        'propertyUuid' => trim(htmlspecialchars($value['uuid'])),
                        'county' => trim(htmlspecialchars($value['county'])),
                        'country' => trim(htmlspecialchars($value['country'])),
                        'town' => trim(htmlspecialchars($value['town'])),
                        'description' => trim(htmlspecialchars($value['description'])),
                        'displayableAddress' => trim( htmlspecialchars($value['address'])),
                        'image' => trim(htmlspecialchars($value['image_full'])),
                        'thumbnail' => trim( htmlspecialchars($value['image_thumbnail'])),
                        'latitude' => trim( htmlspecialchars($value['latitude'])),
                        'longitude' => trim( htmlspecialchars($value['longitude'])) ,
                        'numberofBedrooms' => trim( htmlspecialchars($value['num_bedrooms'])),
                        'numberofBathrooms' => trim( htmlspecialchars($value['num_bathrooms'])),
                        'price' => trim( htmlspecialchars($value['price'])),
                        'propertyTypeId' => trim( htmlspecialchars($value['property_type']['id'])),
                        'forSaleOrRent' => trim( htmlspecialchars($value['type'])),
                        'createdAt' => Carbon::now(),
                        'updatedAt' => Carbon::now()
                    ];

                    if(!in_array($preparedDataProperties, $propertiesData, true)){
                        array_push($propertiesData, $preparedDataProperties);
                    }

                    $preparedDataPropertyType = [
                        'propertyTypeId' => trim(htmlspecialchars($value['property_type']['id'])),
                        'title' => trim(htmlspecialchars($value['property_type']['title'])),
                        'description' => trim(htmlspecialchars($value['property_type']['description'])),
                        'createdAt' => $value['property_type']['created_at'],
                        'updatedAt'=> Carbon::now()
                    ];

                    if(!in_array($preparedDataPropertyType, $propertiesDataType, true)){
                        array_push($propertiesDataType, $preparedDataPropertyType);
                    }
                }

                $mytcApiUrl =  substr($mytcApiUrl,0,93);
                $x++;

                if ( $x % 50 == 0 ) sleep(40);
                
                $mytcApiUrl .= '&page%5Bnumber%5D='.$x;

        } while ($x <= $properties['last_page']);

        DB::transaction(function () use ($propertiesData, $propertiesDataType)  {
            DB::table('properties')->insertOrIgnore($propertiesData);
        
            DB::table('propertytype')->insertOrIgnore($propertiesDataType);
        });

        echo "successfully entered";
    }

    public static function instance()
    {
        return new ApiConnector();
    }
}
<?php

namespace App\Resources\User;

use App\Models\User\Location;

use League\Fractal\Manager;

use League\Fractal\Resource\Collection;

use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Boolean;

class LocationCollection
{

    protected $fractal;

    public function __construct()
    {

        $this->fractal = new Manager();

    }

    /**
     * Get the locations from the user_location Table.
     *
     * @return array $locationData
     */
    public function getAllLocation()
    {
        $locationData = "";

        try {

            $locationData = Location::all();

            if ($locationData) {

                $locationData = $this->formatData($locationData->toArray());
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }

        return $locationData;
    }

    /**
     * Add the loaction to the user_location Table.
     *
     * @return array $returnResponse
     */
    public function locationAdd($request)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            // validate
            // read more on validation at http://laravel.com/docs/validation
            $rules = array(
                'name'       => 'required',
                'status'       => 'required'
            );
            $validator = Validator::make($request->all(), $rules);

            // process the login
            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Save failed";

                // return Redirect::to('nerds/create')
                //     ->withErrors($validator)
                //     ->withInput(Input::except('password'));

            } else {

                // store
                $location = new Location;
                $location->name = $request->get('name');
                $location->status = $request->get('status');
                $location->save();

                $returnResponse["success"] = "true";
                $returnResponse["message"] = "Saved successfully";
            }
        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();

        }

        return $returnResponse;
    }

    /**
     * Edit the location in user_location table based on location id.
     *
     * @return array $returnResponse
     */
    public function locationEdit($request)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            // validate
            // read more on validation at http://laravel.com/docs/validation
            $rules = array(
                'name'       => 'required',
                'status'       => 'required'
            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Update failed";
            } else {

                // update
                $location = Location::find($request->get('id'));
                $location->name = $request->get('name');
                $location->status = $request->get('status');
                $location->save();

                $returnResponse["success"] = "true";
                $returnResponse["message"] = "Updated successfully";
            }
        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();

        }

        return $returnResponse;
    }

    /**
     * Delete location in user_location table based on location id.
     *
     * @return array $returnResponse
     */
    public function locationDelete($request)
    {

        $returnResponse = [
            "success" => "false",
            "error" => "false",
            "data" => "",
            "message" => "",
        ];

        try {

            // validate
            // read more on validation at http://laravel.com/docs/validation
            $rules = array(
                'id'       => 'required'
            );
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {

                $returnResponse["error"] = "true";
                $returnResponse["message"] = "Delete failed";
            } else {

                // delete
                $location = Location::find($request->get('id'));
                $location->delete();

                $returnResponse["success"] = "true";
                $returnResponse["message"] = "Deleted successfully";
            }
        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();
            
        }

        return $returnResponse;
    }

    /**
     * Get the location from the user_location Table by location field array.
     *
     * @param  array $field
     * @return array $locationData
     */
    public function getLocation($field)
    {
        $locationData = "";

        try {

            // $field = [
            //     ['name', 'test'],
            //     ['id', '<>', '5']
            // ];

            $locationData = Location::where($field)->get();

            if ($locationData) {

                $locationData = $locationData->toArray();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }

        return $locationData;
    }

    /**
     * Get the active locations from the user_location Table.
     *
     * @return array $locationData
     */
    public function getActiveLocations()
    {
        $locationData = "";

        try {
            $location = Location::all();

            $locationData = $location->reject(

                function ($location) {

                    return $location->status === false;
                }

            )->pluck("name", "id");

            if ($locationData) {

                $locationData = $locationData->toArray();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }

        return $locationData;
    }

    public function formatData($items)
    {

        // $resource = new Collection($items, function (array $item) {

        //     return [

        //         'id'      => (int) $item['id'],
        //         'name'   => $item['name'],
        //         'status'    => (bool) $item['status'],
        //         'created_at' => date('d-M-y', strtotime($item['created_at'])),
        //         'updated_at' => date('d-M-y', strtotime($item['updated_at'])),

        //     ];
        // });

        // return $resource->getData();

        // Turn that into a structured array (handy for XML views or auto-YAML converting)
        // return  $this->fractal->createData($resource)->toArray();

        $resource = array_map(

            function ($item) {

                return [

                    'id'      => (int) $item['id'],
                    'name'   => $item['name'],
                    'status'    => $item['status'],
                    'created_at' => date('d-M-y', strtotime($item['created_at'])),
                    'updated_at' => date('d-M-y', strtotime($item['updated_at'])),

                ];
            },
            $items
        );

        return $resource;

    }
    
}

// // Model path
// use App\Job;
// // Resource path
// use App\Http\Resources\JobCollection;
// // Calling procedure
// Route::get('/jobs', function () {
//        return new JobCollection(Job::all());
// });
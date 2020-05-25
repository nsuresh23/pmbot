<?php

namespace App\Resources\User;

use App\Models\User\Group;

use League\Fractal\Manager;

use League\Fractal\Resource\Collection;

use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Boolean;

class GroupCollection
{

    protected $fractal;

    public function __construct()
    {

        $this->fractal = new Manager();

    }

    /**
     * Get the groups from the user_group Table.
     *
     * @return array $groupData
     */
    public function getAllGroup()
    {
        $groupData = "";

        try {

            $groupData = Group::all();

            if ($groupData) {

                $groupData = $this->formatData($groupData->toArray());

            }

        } catch (Exception $e) {

            return $e->getMessage();
        }

        return $groupData;
    }

    /**
     * Add the group to the user_group Table.
     *
     * @return array $returnResponse
     */
    public function groupAdd($request)
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
                $group = new Group;
                $group->name = $request->get('name');
                $group->status = $request->get('status');
                $group->save();

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
     * Edit the group in user_group table based on group id.
     *
     * @return array $returnResponse
     */
    public function groupEdit($request)
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
                $group = Group::find($request->get('id'));
                $group->name = $request->get('name');
                $group->status = $request->get('status');
                $group->save();

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
     * Delete the group in user_group table based on group id.
     *
     * @return array $returnResponse
     */
    public function groupDelete($request)
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
                $group = Group::find($request->get('id'));
                $group->delete();

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
     * Get the active groups from the user_group Table.
     *
     * @return array $groupData
     */
    public function getActiveGroups()
    {
        $groupData = "";

        try {

            $group = Group::all();

            $groupData = $group->reject(

                function ($group) {

                    return $group->status === false;
                }

            )->pluck("name", "id");

            if ($groupData) {

                $groupData = $groupData->toArray();
            }
        } catch (Exception $e) {

            return $e->getMessage();
        }

        return $groupData;
    }

    /**
     * Get the group from the user_group Table by group field array.
     *
     * @param  array $field
     * @return array $groupData
     */
    public function getGroup($field)
    {
        $groupData = "";

        try {

            // $field = [
            //     ['name', 'test'],
            //     ['id', '<>', '5']
            // ];

            $groupData = Group::where($field)->get();

            if($groupData) {

                $groupData = $groupData->toArray();

            }
        } catch (Exception $e) {

            return $e->getMessage();
        }

        return $groupData;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }

    public function formatData($items)
    {

        // $resource = new Collection($items, function (array $item) {

        //     return [

        //         'id'      => (int) $item['id'],
        //         'name'   => $item['name'],
        //         'status'    => (boolean) $item['status'],
        //         'created_at' => date('d-M-y', strtotime($item['created_at'])),
        //         'updated_at' => date('d-M-y', strtotime($item['updated_at'])),

        //     ];

        // });


        // return $resource->getData();

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

        // Turn that into a structured array (handy for XML views or auto-YAML converting)
        // return  $this->fractal->createData($resource)->toArray();
    }

    // public function formatData($items)
    // {

    //     $resource = new Collection($items, function (array $item) {
    //         return [
    //             'id'      => (int) $item['id'],
    //             'title'   => $item['title'],
    //             'year'    => (int) $item['yr'],
    //             'author'  => [
    //                 'name'  => $item['author_name'],
    //                 'email' => $item['author_email'],
    //             ],
    //             'links'   => [
    //                 [
    //                     'rel' => 'self',
    //                     'uri' => '/data/' . $item['id'],
    //                 ]
    //             ]
    //         ];
    //     });

    //     // Turn that into a structured array (handy for XML views or auto-YAML converting)
    //     return  $this->fractal->createData($resource)->toArray();

    // }

    

    // /**
    //  * Transform the resource collection into an array.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return array
    //  */
    // public function toArray($request)
    // {
    //     return [
    //         'data' => $this->collection,
    //         'links' => [
    //             'self' => 'link-value',
    //         ],
    //     ];
    // }
}

// // Model path
// use App\Job;
// // Resource path
// use App\Http\Resources\JobCollection;
// // Calling procedure
// Route::get('/jobs', function () {
//        return new JobCollection(Job::all());
// });
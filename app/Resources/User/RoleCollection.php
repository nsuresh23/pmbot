<?php

namespace App\Resources\User;

use App\Models\User\Role;

use League\Fractal\Manager;

use League\Fractal\Resource\Collection;

use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Boolean;

class RoleCollection
{

    protected $fractal;

    public function __construct()
    {

        $this->fractal = new Manager();

    }

    /**
     * Get the roles from the user_role Table.
     *
     * @return array $roleData
     */
    public function getAllRole()
    {
        $roleData = "";

        try {

            $roleData = Role::all();

            if ($roleData) {

                $roleData = $this->formatData($roleData->toArray());
            }

        } catch (Exception $e) {

            return $e->getMessage();
        }

        return $roleData;
    }

    /**
     * Add the role to the user_role Table.
     *
     * @return array $returnResponse
     */
    public function roleAdd($request)
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
                $role = new Role;
                $role->name = $request->get('name');
                $role->status = $request->get('status');
                
                if($role->save()) {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Save successfull";

                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Save unsuccessfull";

                }

            }

        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();
        }

        return $returnResponse;
    }

    /**
     * Edit the role in user_role table based on role id.
     *
     * @return array $returnResponse
     */
    public function roleEdit($request)
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
                $role = Role::find($request->get('id'));
                $role->name = $request->get('name');
                $role->status = $request->get('status');

                if ($role->save()) {

                    $returnResponse["success"] = "true";
                    $returnResponse["message"] = "Update successfull";
                } else {

                    $returnResponse["error"] = "true";
                    $returnResponse["message"] = "Update unsuccessfull";
                }

            }
        } catch (Exception $e) {

            $returnResponse["error"] = "true";
            $returnResponse["message"] = $e->getMessage();

        }

        return $returnResponse;
    }

    /**
     * Delete the role in user_role table based on role id.
     *
     * @return array $returnResponse
     */
    public function roleDelete($request)
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
                $role = Role::find($request->get('id'));
                $role->delete();

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
     * Get the role from the user_role Table by role field array.
     *
     * @param  array $field
     * @return array $roleData
     */
    public function getRole($field)
    {
        $roleData = "";

        try {

            // $field = [
            //     ['name', 'test'],
            //     ['id', '<>', '5']
            // ];

            $roleData = Role::where($field)->get();

            if($roleData) {

                $roleData = $roleData->toArray();

            }
        } catch (Exception $e) {

            return $e->getMessage();
        }

        return $roleData;
    }

    /**
     * Get the active roles from the user_role Table.
     *
     * @return array $roleData
     */
    public function getActiveRoles()
    {
        $roleData = "";

        try {

            // $field = [
            //     ['name', 'test'],
            //     ['id', '<>', '5']
            // ];

            $role = Role::all();

            // $roleData = $role->reject(

            //     function ($role) {

            //         return $role->status === false;

            //     }

            // )->map(
                
            //     function ($role) {

            //         return [
            //             "id" => $role->id,
            //             "name" => $role->name
            //         ];

            //     }

            // );

            $roleData = $role->reject(

                function ($role) {

                    return $role->status === false;
                }

            )->pluck("name", "id");

            if ($roleData) {

                $roleData = $roleData->toArray();
            }

        } catch (Exception $e) {

            return $e->getMessage();
        }

        return $roleData;
        
    }

    public function formatData($items)
    {

        // $resource = new Collection($items, function (array $item) {

        //     return [

        //         'id'      => (int) $item['id'],
        //         'name'   => $item['name'],
        //         'status'    => (boolean) $item['status'],
        //         'created_at' => date('d-M-y',strtotime($item['created_at'])),
        //         'updated_at' => date('d-M-y',strtotime($item['updated_at'])),

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
                    'created_at' => date('d-M-y',strtotime($item['created_at'])),
                    'updated_at' => date('d-M-y',strtotime($item['updated_at'])),

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
<?php

namespace App\Resources;
namespace App\Traits\General;

use App\Traits\General\ApiClient;

use Illuminate\Http\Resources\Json\JsonResource;

class Job extends JsonResource
{
    protected $client;

    protected $jobByIdUrl;

    public function __construct(ApiClient $apiClient)
    {
        $this->client = $apiClient;
        $this->jobByIdUrl = env('JOB_BY_ID');
    }

    public function getJobData($id)
    {
        $jobData = "";

        try {
            
            $url = $this->jobByIdUrl . $id;

            $jobData = $this->client->getRequest($id);
            
		} catch (Exception $e) {

            return $e->getMessage();

        }
        
        return $jobData;
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
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}

// // Model path
// use App\Job;
// // Resource path
// use App\Http\Resources\Job as JobResource;
// // Calling procedure
// Route::get('/job', function () {
//     return new JobResource(Job::find(1));
// });

// // Model path
// use App\Job;
// // Resource path
// use App\Http\Resources\Job as JobResource;
// // Calling collection procedure
// Route::get('/jobs', function () {
//     return JobResource::collection(Job::all());
// });



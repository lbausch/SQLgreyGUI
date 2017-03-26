<?php

namespace SQLgreyGUI\Api\v1\Controllers;

use Illuminate\Container\Container;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Bausch\LaravelCornerstone\Http\Controllers\CornerstoneController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use League\Fractal\Resource\Item;
use League\Fractal\Manager;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Resource\Collection;
use League\Fractal\TransformerAbstract;

abstract class Controller extends CornerstoneController
{
    use ValidatesRequests;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        parent::__construct();

        if (app()->environment('local')) {
            sleep(1);
        }
    }

    /**
     * Convert base64 encoded JSON to array.
     *
     * @param $string
     *
     * @return array
     */
    protected function convertData($string)
    {
        return json_decode(base64_decode($string, $strict = true), $assoc = true);
    }

    /**
     * Respond.
     *
     * @param array $data
     * @param int   $status
     * @param array $headers
     * @param int   $options
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respond($data, $status = 200, array $headers = [], $options = 0)
    {
        $payload = [
            'status' => true,
            'data' => $data,
        ];

        $response = Container::getInstance()->make(ResponseFactory::class);

        return $response->json($payload, $status, $headers, $options);
    }

    /**
     * Respond success.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondSuccess()
    {
        $response = Container::getInstance()->make(ResponseFactory::class);

        return $response->json(['status' => true]);
    }

    /**
     * Respond with a Collection.
     *
     * @param mixed                    $item
     * @param TransformerAbstract|null $transformer
     * @param string|null              $resourceKey
     *
     * @return \Illuminate\Http\Response
     */
    public function respondItem($item, TransformerAbstract $transformer = null, $resourceKey = null)
    {
        $manager = $this->getManager();

        $resource = new Item($item, $transformer, $resourceKey);
        $data = $manager->createData($resource)->toArray();

        return $this->respond($data['data']);
    }

    /**
     * Respond with a Collection.
     *
     * @param mixed                    $collection
     * @param TransformerAbstract|null $transformer
     * @param string|null              $resourceKey
     *
     * @return \Illuminate\Http\Response
     */
    public function respondCollection($collection, TransformerAbstract $transformer = null, $resourceKey = null)
    {
        // If no transformer is given and we're dealing with a \Illuminate\Support\Collection
        // then convert the Collection to an array and respond accordingly.
        if (is_null($transformer) && $collection instanceof \Illuminate\Support\Collection) {
            return $this->respond($collection->toArray());
        }

        $manager = $this->getManager();

        $resource = new Collection($collection, $transformer, $resourceKey);
        $data = $manager->createData($resource)->toArray();

        return $this->respond($data['data']);
    }

    /**
     * Get a \League\Fractal\Manager instance.
     *
     * @param Request|null $request
     *
     * @return Manager
     */
    protected function getManager(Request $request = null)
    {
        // If no Request is provided just use the current one
        if (is_null($request)) {
            $request = Container::getInstance()->make('request');
        }

        $manager = new Manager();

        // Set the Serializer which should be used
        $manager->setSerializer(new DataArraySerializer());

        // Check for any requested includes
        $manager->parseIncludes($request->query('include', ''));

        return $manager;
    }
}

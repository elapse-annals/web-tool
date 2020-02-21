<?php

namespace App\Http\Controllers;

use App\Exports\ArrayExport;
use App\Formatters\ArrayFormatter;
use App\Transformers\ArrayTransformer;
use App\Services\ArrayService;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * Class ArrayController
 *
 * @package App\Http\Controllers
 */
class ArrayController extends Controller
{
    /**
     * @var ArrayService
     */
    protected $service;
    /**
     * ArrayFormatter
     *
     * @var ArrayFormatter
     */
    private $formatter;
    /**
     * @var ArrayTransformer
     */
    private $transformer;

    /**
     * @var bool
     */
    private $enable_filter = true;

    /**
     * ArrayController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->service = new ArrayService();
        if ($this->enable_filter) {
            $this->formatter = new ArrayFormatter();
            $this->transformer = new ArrayTransformer();
        }
    }

    /**
     * @param Request $request
     *
     * @return array|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        try {
            $data = $request->input();
            if (true == $request->input('api')) {
                $data = array_map(function ($datum) {
                    return json_decode($datum, true);
                }, $data);
            }
            $this->validationIndexRequest($data);
            $arrays = $this->service->getList($data);
            if ($request->is('api/*') || true == $request->input('api')) {
                return $this->successReturn($arrays, $this->formatter->assemblyPage($arrays));
            }
            $table_comment_map = $this->getTableCommentMap('arrays');
            //            $table_comment_map = $this->appendAssociationModelMap($table_comment_map);
            $view_data = [
                'info'       => $this->getInfo('index'),
                'arrays'      => $arrays,
                'list_map'   => $table_comment_map,
                'search_map' => $table_comment_map,
            ];
            if ($this->enable_filter) {
                $view_data = $this->transformer->transformIndex(
                    $this->formatter->formatIndex($view_data)
                );
            }
            return view('arrays.index', $view_data);
        } catch (Exception $exception) {
            return [$exception->getMessage(), $exception->getFile(), $exception->getLine()];
        }
    }

    /**
     * @param array $data
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validationIndexRequest(array $data)
    {
        $rules = [
        ];
        $messages = [
            'page' => '分页',
        ];
        if ($rules) {
            $this->validate($data, $rules, $messages);
        }
    }

    /**
     * @param Request $request
     *
     * @return array|int
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->input();
            $this->validateStoreRequest($data);
            $store_status = $this->service->store($data);
            DB::commit();
            return $this->successReturn($store_status);
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->catchException($exception, 'api');
        }
    }

    /**
     * @param $data
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    private function validateStoreRequest($data)
    {
        $rules = [];
        $messages = [];
        if (! empty($rules)) {
            $this->validate($data, $rules, $messages);
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        try {
            $view_data = [
                'info'        => $this->getInfo('create'),
                'js_data'     => [
                    'data' => [],
                ],
                'detail_data' => $this->getTableCommentMap('arrays'),
            ];
            return view('arrays.create', $view_data);
        } catch (Exception $exception) {
        }
    }

    /**
     * @param Request $request
     * @param int     $id
     * @param bool    $is_edit
     *
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Request $request, int $id, $is_edit = false)
    {
        try {
            $this->validationShowRequest($id);
            $array = $this->service->getIdInfo($id);
            $view_data = [
                'info'        => $this->getInfo('show'),
                'js_data'     => [
                    'detail_data' => $array,
                ],
                'detail_data' => $this->getTableCommentMap('arrays'),
            ];
            if ($this->enable_filter) {
                $view_data = $this->transformer->transformShow(
                    $this->formatter->formatShow($view_data)
                );
            }
            if ($request->is('api/*') || true == $request->input('api') || $is_edit) {
                return $view_data;
            }
            return view('arrays.show', $view_data);
        } catch (Exception $exception) {
            return $this->catchException($exception);
        }
    }

    /**
     * @param $id
     *
     * @throws Exception
     */
    private function validationShowRequest($id)
    {
        if (empty($id)) {
            throw new Exception(trans('request id is null'));
        }
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $data = $request->input();
            $this->validateUpdateRequest($data, $id);
            $res_db = $this->service->update($data, $id);
            DB::commit();
            if ($request->is('api/*') ||
                true == $request->input('api') ||
                'json' === $request->getContentType()
            ) {
                return $this->successReturn($res_db);
            }
            $view_data = $this->show($request, $id, true);
            return view('arrays.show', $view_data);
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->catchException($exception, 'api');
        }
    }

    /**
     * @param $id
     * @param $data
     *
     * @throws Exception
     */
    private function validateUpdateRequest($data, $id)
    {
        $this->validateRequestId($id);
    }

    /**
     * @param int $id
     *
     * @return array|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws Exception
     */
    public function destroy(int $id)
    {
        try {
            DB::beginTransaction();
            $this->validateDestroy($id);
            $res_db = $this->service->destroy($id);
            DB::commit();
            return $this->successReturn($res_db);
        } catch (Exception $exception) {
            DB::rollBack();
            return $this->catchException($exception, 'api');
        }
    }

    /**
     * @param int $id
     *
     * @throws Exception
     */
    private function validateDestroy(int $id)
    {
        $this->validateRequestId($id);
    }

    /**
     * @param Request $request
     * @param         $id
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Request $request, $id)
    {
        $view_data = $this->show($request, $id, true);
        return view('arrays.edit', $view_data);
    }

    /**
     * @param $type
     *
     * @return array
     */
    private function getInfo($type): array
    {
        return [
            'description' => "array {$type} description",
            'author'      => 'Ben',
            'title'       => "array {$type} title",
        ];
    }

    /**
     * @param int $id
     *
     * @throws Exception
     */
    private function validateRequestId(int $id): void
    {
        if (empty($id)) {
            throw new Exception('request id is empty');
        }
    }

    public function export()
    {
        $excel_name = 'array.xls';
        return Excel::download(new ArrayExport, $excel_name);
    }

    public function testQueryDb()
    {
//        return 'yoyo';
        /*$act_time = microtime(true);
        $sum = 0;
        for ($i = 1; $i < 100000; $i++) {
            $sum = $sum * round(0, 1) + $sum;
        }
        return microtime(true) - $act_time;*/
        $act_time = microtime(true);
        for ($i = 1; $i < 10; $i++) {
            $res = DB::select("SELECT * FROM arrays LIMIT {$i},1;");
        }
        return microtime(true) - $act_time;
    }
}

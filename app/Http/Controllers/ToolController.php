<?php

namespace App\Http\Controllers;

use App\Exports\ToolExport;
use App\Formatters\ToolFormatter;
use App\Transformers\ToolTransformer;
use App\Services\ToolService;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


/**
 * Class ToolController
 *
 * @package App\Http\Controllers
 */
class ToolController extends Controller
{
    /**
     * @var ToolService
     */
    protected $service;
    /**
     * ToolFormatter
     *
     * @var ToolFormatter
     */
    private $formatter;
    /**
     * @var ToolTransformer
     */
    private $transformer;

    /**
     * @var bool
     */
    private $enable_filter = true;

    /**
     * ToolController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->service = new ToolService();
        if ($this->enable_filter) {
            $this->formatter = new ToolFormatter();
            $this->transformer = new ToolTransformer();
        }
    }

    public function lists()
    {
        return view('tools.lists');
    }

    public function stringToArray(Request $request)
    {
        $data = [
            'string'    => $request->post('string'),
            'array'     => null,
            'delimiter' => $request->post('delimiter') ?: ',',
        ];
        if ($request->isMethod('post')) {
            $temp_array = explode($data['delimiter'], $data['string']);
            foreach ($temp_array as $value) {
                $data['array'] .= $value . PHP_EOL;
            }
        }
        return view('tools.string_to_array', $data);
    }

    public function arrayToString(Request $request)
    {
        $data = [
            'array'     => $request->post('array'),
            'string'    => null,
            'delimiter' => $request->post('delimiter') ?: ',',
        ];
        if ($request->isMethod('post')) {
            $temp_array = explode(PHP_EOL, $data['array']);
            $temp_array = array_map(function ($value) {
                return trim($value);
            }, $temp_array);
            $data['string'] = implode($data['delimiter'], $temp_array);
        }
        return view('tools.array_to_string', $data);
    }

    public function arrayCompare()
    {
        return view('tools.array_compare');

    }

    public function arrayMerge()
    {
        return view('tools.array_merge');

    }

}

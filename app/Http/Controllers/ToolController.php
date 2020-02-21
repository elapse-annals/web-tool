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

    public function stringToArray()
    {
        
    }

    public function arrayToString()
    {
        
    }
    
}

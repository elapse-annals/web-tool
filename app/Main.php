<?php
/**
 * User: ben
 * Date: 19/7/8
 * Time: 14:00
 */

namespace App;

use Noodlehaus\Config;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Class main
 *
 * @package App
 */
class Main
{
    /**
     * @var Config
     */
    protected $config;
    /**
     * @var Logger|string
     */
    protected $log;

    /**
     * main constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->config = Config::load(__DIR__ . '/../config/app.php');
        $this->log = new Logger('app');
        $this->log->pushHandler(new StreamHandler(__DIR__ . '/../logs/app.log', Logger::DEBUG));
    }

    /**
     * @return null
     */
    public function run()
    {
        $this->log->info('Hello', ['world']);
        $this->log->debug('config', (array)$this->config->all());
        return null;
    }
}

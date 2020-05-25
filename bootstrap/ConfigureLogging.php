<?php 

// bootstrap/ConfigureLogging

namespace Bootstrap;

use Monolog\Logger as Monolog;
use Illuminate\Log\Writer;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Bootstrap\ConfigureLogging as BaseConfigureLogging;
use Monolog\Handler\StreamHandler;

class ConfigureLogging extends BaseConfigureLogging{

    const LINE_FORMAT = "[%datetime%] %level_name%: %message% %context% %extra%\n";

    /**
     * OVERRIDE PARENT
     * Configure the Monolog handlers for the application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  \Illuminate\Log\Writer  $log
     * @return void
     */
    protected function configureHandlers(Application $app, Writer $log)
    {

        $bubble = false;

        // Stream Handlers
        $infoStreamHandler = new StreamHandler( storage_path("/logs/laravel_info" . date('Y-m-d') . ".log"), Monolog::INFO, $bubble);
        $warningStreamHandler = new StreamHandler( storage_path("/logs/laravel_warning" . date('Y-m-d') . ".log"), Monolog::WARNING, $bubble);
        $errorStreamHandler = new StreamHandler( storage_path("/logs/laravel_error" . date('Y-m-d') . ".log"), Monolog::ERROR, $bubble);

        // Get monolog instance and push handlers
        $monolog = $log->getMonolog();
        $monolog->pushHandler($infoStreamHandler);
        $monolog->pushHandler($warningStreamHandler);
        $monolog->pushHandler($errorStreamHandler);

        
        // $handler = new RotatingFileHandler(
        //     $path,
        //     $numOfKeepFiles,
        //     $this->parseLevel($level)
        // );

        // $handler->setFormatter(
        //     new LineFormatter(static::LINE_FORMAT, null, true, true)
        // );

        // $log->pushHandler($handler);


        $log->useDailyFiles($app->storagePath().'/logs/daily' . date('Y-m-d') . '.log');
    }

}
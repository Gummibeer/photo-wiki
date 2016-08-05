<?php

namespace App\Libs;

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Queue\Console\WorkCommand;
use Symfony\Component\Console\Input\ArgvInput;

class Helper
{
    public function getLogContext(array $context = [])
    {
        $now = Carbon::now('UTC');
        $defaults = [
            'cli' => false,
            'timestamp' => $now->getTimestamp(),
            'datetime' => $now,
        ];

        if (app()->runningInConsole()) {
            $defaults['cli'] = true;
            $input = new ArgvInput();
            $command = array_get(\Artisan::all(), $input->getFirstArgument());
            $defaults['class'] = get_class($command);
            if (! ($command instanceof WorkCommand)) {
                if (method_exists($command, 'getInput')) {
                    $defaults['options'] = $command->getInput()->getOptions();
                }
                $defaults['command'] = $input->getFirstArgument();
            }
        } else {
            $defaults['controller'] = \Route::currentRouteAction();
            $defaults['uri'] = \Request::getUri();
            $defaults['method'] = \Request::getMethod();
        }

        $context = array_merge($defaults, $context);

        return $context;
    }

    public function mixedGet($object, $key, $default = null)
    {
        if (is_null($key) || trim($key) == '') {
            return '';
        }

        foreach (explode('.', $key) as $segment) {
            if (is_object($object) && isset($object->{$segment})) {
                $object = $object->{$segment};
            } elseif (is_object($object) && method_exists($object, 'getAttribute') && ! is_null($object->getAttribute($segment))) {
                $object = $object->getAttribute($segment);
            } elseif (is_array($object) && array_key_exists($segment, $object)) {
                $object = array_get($object, $segment, $default);
            } else {
                return value($default);
            }
        }

        return $object;
    }

    public function translate($message, $arguments = [])
    {
        $trans = Translator::getInstance()->trans($message, [], null, getUserLanguage());
        $tmp = empty($trans) ? $message : $trans;
        $tmp = count($arguments) ? vsprintf($tmp, $arguments) : $tmp;

        return $tmp;
    }

    public function getUserLanguage()
    {
        if (\Auth::check()) {
            return \Auth::User()->language;
        } else {
            return \Session::get('language', config('app.locale'));
        }
    }

    public function isRoute($arg)
    {
        if (is_array($arg)) {
            $route = array_shift($arg);
            $arg = trim(route($route, $arg, false), '/');
        } else {
            $arg = trim(route($arg, [], false), '/');
        }

        return call_user_func_array([app('request'), 'is'], [$arg]);
    }

    public function isJson($json)
    {
        json_decode($json);

        return json_last_error() == JSON_ERROR_NONE;
    }

    public function isActiveLdap()
    {
        $authProvider = \Auth::getProvider();

        return (bool) ($authProvider instanceof ActiveDirectoryAuthUserProvider);
    }

    public function getStub($file)
    {
        $stubPath = app_path('Stubs/'.$file.'.stub');
        if (file_exists($stubPath)) {
            return file_get_contents($stubPath);
        }
    }

    public function formatCliToHtml($string)
    {
        $removes = [
            "\r\e[K\e[1A\r",
        ];
        $string = str_replace($removes, '', $string);
        $string = $this->bashColorToHtml($string);
        $string = implode("\n", array_map('trim', explode("\n", $string)));

        return nl2br($string);
    }

    public function bashColorToHtml($string)
    {
        $colors = [
            '/\[0;30m(.*?)\[0m/s' => '<span class="black">$1</span>',
            '/\[0;31m(.*?)\[0m/s' => '<span class="red">$1</span>',
            '/\[0;32m(.*?)\[0m/s' => '<span class="green">$1</span>',
            '/\[0;33m(.*?)\[0m/s' => '<span class="brown">$1</span>',
            '/\[0;34m(.*?)\[0m/s' => '<span class="blue">$1</span>',
            '/\[0;35m(.*?)\[0m/s' => '<span class="purple">$1</span>',
            '/\[0;36m(.*?)\[0m/s' => '<span class="cyan">$1</span>',
            '/\[0;37m(.*?)\[0m/s' => '<span class="light-gray">$1</span>',

            '/\[1;30m(.*?)\[0m/s' => '<span class="dark-gray">$1</span>',
            '/\[1;31m(.*?)\[0m/s' => '<span class="light-red">$1</span>',
            '/\[1;32m(.*?)\[0m/s' => '<span class="light-green">$1</span>',
            '/\[1;33m(.*?)\[0m/s' => '<span class="yellow">$1</span>',
            '/\[1;34m(.*?)\[0m/s' => '<span class="light-blue">$1</span>',
            '/\[1;35m(.*?)\[0m/s' => '<span class="light-purple">$1</span>',
            '/\[1;36m(.*?)\[0m/s' => '<span class="light-cyan">$1</span>',
            '/\[1;37m(.*?)\[0m/s' => '<span class="white">$1</span>',
        ];

        return preg_replace(array_keys($colors), $colors, $string);
    }

    public function getGeolocByAddress($address)
    {
        $url = 'https://places-dsn.algolia.net/1/places/query';
        $data = [
            'query' => $address,
            'hitsPerPage' => 1,
        ];

        $client = new Client([
            'base_uri' => $url,
        ]);
        $response = $client->request('POST', '', [
            'body' => json_encode($data),
        ]);
        if ($response->getStatusCode() == 200) {
            $body = (string) $response->getBody();
            if (is_json($body)) {
                $data = json_decode($body, true);
                if (array_key_exists('hits', $data) && count($data['hits']) > 0) {
                    $hit = array_first($data['hits']);
                    if (is_array($hit) && array_key_exists('_geoloc', $hit)) {
                        return $hit['_geoloc'];
                    }
                }
            }
        }
    }

    public function getLanguageFromLocale($locale)
    {
        return array_get(explode('-', $locale), 0);
    }

    public function formatCarbonDatetime($carbon)
    {
        if($carbon instanceof Carbon) {
            return $carbon->format(trans('helpers.datetimeformat.php'));
        }
    }

    public function isDateFormat($format, $value)
    {
        $parsed = date_parse_from_format($format, $value);
        return (bool) $parsed['error_count'] === 0 && $parsed['warning_count'] === 0;
    }
}

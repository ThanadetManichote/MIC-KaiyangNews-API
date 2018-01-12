<?php
namespace App\Controllers;

use Phalcon\Mvc\Controller;
use Phalcon\Http\Response;
use Phalcon\Validation;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Numericality;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Email as EmailValidator;
use Phalcon\Validation\Validator\Date as DateValidator;
use Phalcon\Validation\Validator\Uniqueness as UniquenessValidator;
use Phalcon\Validation\Validator\Alnum as AlnumValidator;
use Phalcon\Translate\Adapter\NativeArray;
use App\Library\ApiKeyServices;
use MongoDB\BSON\ObjectID;
use MongoDB\BSON\Regex;
class ApiController extends Controller
{
    private $mode = false;
    private $data = false;

    public function onConstruct()
    {
        $this->response = new \Phalcon\Http\Response();
        $this->response->setStatusCode(200, 'OK');
        $this->response->setHeader('Content-Type', 'application/json');

        $this->request = new \Phalcon\Http\Request();

        $this->input   = $this->request->getQuery();

        $this->page    = isset($this->input['page']) && $this->input['page'] != '' ? (int) $this->input['page'] : 1;
        $this->perpage = isset($this->input['perpage']) && $this->input['perpage'] != '' ? (int) $this->input['perpage'] : 20;

        $this->offset  = isset($this->input['offset']) && $this->input['offset'] != '' ? (int) $this->input['offset'] : 0;
        $this->limit  = isset($this->input['limit']) && $this->input['limit'] != '' ? (int) $this->input['limit'] : 0;

        if ($this->limit > 0) { $this->perpage = $this->limit; }
        if ($this->offset > 0) { $this->page  = ($this->offset / $this->perpage) + 1; }

        $this->order   = isset($this->input['order']) && $this->input['order'] != '' ? $this->input['order'] : false;
        $this->sort    = isset($this->input['sort']) && $this->input['sort'] != '' ? $this->input['sort'] : 'desc';
    }

    protected function postInput()
    {
        $request  = $this->request;
        $rawInput = $request->getRawBody();
        $inputs   = json_decode($rawInput, true);

        if (empty($inputs) && $request->isPost()) {
            return $request->getPost();
        }

        return $inputs;
    }

    /**
     * Method for get put paramerter
     * @return array
     */
    protected function putInput()
    {
        $request  = $this->request;
        $rawInput = json_decode($request->getRawBody(), true);

        if (is_null($rawInput) && $request->isPut()) {
            return $request->getPut();
        }

        return is_array($rawInput) ? $rawInput : [];
    }

    protected function getInput()
    {
        $params = $this->request->getQuery();

        unset($params["_url"]);
        return $params;
    }

    protected function validateApi($rules, $default = [], $input = [])
    {
        $return   = [];
        $validate = $this->validate($input, $rules);

        if (!empty($validate['error']))  {
            return [
                'msgError'   => $validate['error']->getMessage(),
                'fieldError' => $validate['error']->getField(),
            ];
        }

        foreach (array_keys($default) as $s_value) {
            if (isset($input[$s_value]) && !empty($input[$s_value])) {
                $return[$s_value] = $input[$s_value];
            } else {
                $return[$s_value] = $default[$s_value];
            }
        }

        return array_merge($input, $return);
    }

    protected function validateRegular($input, $field, $validation)
    {
        $language = array_values($this->language['supports']->toArray());

        if (count($input) > 0) {
            foreach ($input as $kInput => $vInput) {
                preg_match('/^' . $field . '$/', $kInput, $text);
                if (count($text) > 0 && isset($text[0]) && isset($text[2])) {
                    if (!in_array($text[2], $language)) {
                        $validation->add($text[0], new PresenceOf([
                            'message' => 'Language not support.',
                        ]));
                        $input[$kInput] = '';
                        continue;
                    }

                    $validation->add($text[0], new PresenceOf([
                        'message' => 'The ' . $text[0] . ' is required',
                    ]));
                }
            }
        }

        return $input;
    }

    /**
     * @param $input
     * @param $rules
     */
    protected function validate($input, $rules)
    {
        $validation = new Validation();

        foreach ($rules as $value) {

            switch (strtolower($value['type'])) {

                case 'required':
                    foreach ($value['fields'] as $field) {
                        if (isset($value['regular']) && $value['regular'] === true) {
                            $input = $this->validateRegular($input, $field, $validation);
                        } else {
                            $validation->add($field, new PresenceOf([
                                'message' => 'The ' . $field . ' is required',
                            ]));
                        }
                    }
                    break;

                case 'number':
                    foreach ($value['fields'] as $field) {
                        $validation->add($field, new Numericality([
                            'message' => ucfirst($field) . ' must be numberic',
                        ]));
                    }
                    break;

                case 'email':
                    foreach ($value['fields'] as $field) {
                        $validation->add($field, new EmailValidator([
                            'message' => $field . ' is not a valid email address',
                        ]));
                    }
                    break;

                case 'date':
                    foreach ($value['fields'] as $field) {
                        $validation->add($field, new DateValidator([
                            'format'  => isset($value['format'][$field]) ? $value['format'][$field] : 'Y-m-d',
                            'message' => 'The ' . $field . ' date is invalid'
                        ]));
                    }
                    break;

                case 'inclusion_in':
                    foreach ($value['fields'] as $field) {
                        $validation->add($field, new InclusionIn([
                            'domain'  => isset($value['domain'][$field]) ? $value['domain'][$field] : [],
                            'message' => 'The ' . $field . ' must be ' . implode(', ', $value['domain'][$field])
                        ]));
                    }
                    break;

                case 'string_length':
                    foreach ($value['fields'] as $field) {
                        $validation->add($field, new StringLength([
                            'max' => $value['check'][$field]['max'],
                            'min' => $value['check'][$field]['min'],
                            'messageMaximum' => $field . ' must be no greater than ' . $value['check'][$field]['max']  . '.',
                            'messageMinimum' => $field . ' must be no less than ' . $value['check'][$field]['min'] . '.'
                        ]));
                    }
                    break;

                case 'alnum':
                    foreach ($value['fields'] as $field) {
                        $validation->add($field, new AlnumValidator([
                            'message' => ':field must contain only alphanumeric characters'
                        ]));
                    }
                    break;

                default:
                //default
            }
        }

        $messages = $validation->validate($input);

        foreach ($messages as $message) {
            return [
                'error' => $message
            ];
        }

        return [];
    }

    /**
     * @param  $fieldError
     * @param  $msgError
     * @param  $statusCode
     * @return mixed
     */
    protected function validateError($fieldError, $msgError, $statusCode = null)
    {
        $status = $this->status;

        if (!empty($statusCode)) {
            $code       = 'code' . $statusCode;
            $text       = 'text' . $statusCode;
            $statusCode = $status[$code];
            $statusText = $status[$text];
        } else {
            $statusCode = $status['code400'];
            $statusText = $status['text400'];
        }

        $output = [
            'status' => [
                'code'    => $statusCode,
                'message' => $statusText,
            ],
            'errors' => [
                0 => [
                    'message' => $msgError,
                ],
            ],
        ];

        if (isset($fieldError) && !empty($fieldError)) {
            $output['errors'][0]['property'] = $fieldError;
        }

        return $this->responseData($output, $statusCode, $msgError);
    }

    /**
     * @param  $data
     * @param  $status_code
     * @param  $message
     * @return mixed
     */
    protected function responseData($data, $status_code = 200, $message = 'Success')
    {
        $this->response->setContentType('application/json', 'UTF-8');
        $this->response->setStatusCode($status_code, $message);
        $this->response->setJsonContent($data);

        return $this->response;
    }

    protected function validateBussinessError($field)
    {
        $errorMsg = $this->message;

        return $this->validateError(
            isset($errorMsg[$field]['fieldError']) ? $errorMsg[$field]['fieldError'] : '',
            $errorMsg[$field]['msgError'],
            $errorMsg[$field]['code']
        );
    }

    // protected function getTranslation()
    // {
    //     $language    = $this->request->getBestLanguage();
    //     $translation = '../app/language/' . $language . '/errormsg.php';

    //     if (file_exists($translation)) {
    //         require $translation;
    //     } else {
    //         require '../app/language/en/errormsg.php';
    //     }

    //     return new NativeArray(
    //         [
    //             'content' => $messages
    //         ]
    //     );
    // }

    protected function getHeaders()
    {
        $request  = $this->request;
        $headers  = $request->getHeaders();

        return $headers;
    }

    protected function setPagination($input)
    {
        $input['page']    = $this->page;
        $input['perpage'] = $this->perpage;
        $input['offset']  = $this->offset;

        return $input;
    }

    public function unitTestAfterExecuteRoute($data = false)
    {
        $this->mode = 'unittest';
        $this->data = $data;

        ob_start();
        self::afterExecuteRoute($data);
        $output = ob_get_contents();
        ob_end_clean();

        return $output;
    }

    public function afterExecuteRoute($dispatcher)
    {
        if ($this->mode == 'unittest') {
            $data = $this->data;

        } else {
            $data = $dispatcher->getReturnedValue();

        }

        if (is_array($data)) {
            $code          = key($data);

            if ($code === 'png') {

                 header('Content-Type: image/png');
                 echo $data['png'];
                 die();

            } else {

                $status_reason = $this->setResponseStatus($code);

                if (isset($data[$code])) {
                    $data = $data[$code];
                }

                if (!isset($data['msgError_en']) && isset($data['msgError']) ) 
                {
                    $data['msgError_en'] = $data['msgError'];
                    $data['msgError_mm'] = t_mm($data['msgError']);
                }
                $this->response->setStatusCode($code);
                $this->response->setJsonContent(array('status_code' => $code, 'status_txt' => $status_reason, 'data' => $data));

            }
        } else {
            $this->response->setJsonContent($data);
        }

        try {
            $this->response->send();
        } catch (\Phalcon\Http\Response\Exception $e) {
        } catch (Exception $e) {
        }
    }

    protected function setResponseStatus($code)
    {
        $status_reason = array(
            0   => 'OK',
            100 => 'Continue',
            101 => 'Switching Protocols',
            102 => 'Processing',
            200 => 'OK',
            201 => 'Created',
            202 => 'Accepted',
            203 => 'Non-Authoritative Information',
            204 => 'No Content',
            205 => 'Reset Content',
            206 => 'Partial Content',
            207 => 'Multi-Status',
            226 => 'IM Used',
            300 => 'Multiple Choices',
            301 => 'Moved Permanently',
            302 => 'Found',
            303 => 'See Other',
            304 => 'Not Modified',
            305 => 'Use Proxy',
            306 => 'Reserved',
            307 => 'Temporary Redirect',
            400 => 'Bad Request',
            401 => 'Unauthorized',
            402 => 'Payment Required',
            403 => 'Forbidden',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            406 => 'Not Acceptable',
            407 => 'Proxy Authentication Required',
            408 => 'Request Timeout',
            409 => 'Conflict',
            410 => 'Gone',
            411 => 'Length Required',
            412 => 'Precondition Failed',
            413 => 'Request Entity Too Large',
            414 => 'Request-URI Too Long',
            415 => 'Unsupported Media Type',
            416 => 'Requested Range Not Satisfiable',
            417 => 'Expectation Failed',
            422 => 'Unprocessable Entity',
            423 => 'Locked',
            424 => 'Failed Dependency',
            426 => 'Upgrade Required',
            500 => 'Internal Server Error',
            501 => 'Not Implemented',
            502 => 'Bad Gateway',
            503 => 'Service Unavailable',
            504 => 'Gateway Timeout',
            505 => 'HTTP Version Not Supported',
            506 => 'Variant Also Negotiates',
            507 => 'Insufficient Storage',
            510 => 'Not Extended'
        );

        return $status_reason[$code];
    }

    /**
     * @return array
     */
    protected function output($code = 400, array $records, $paginate = false)
    {
        if ($paginate) {
            $pagination = [
                'page'          => (int) array_get($paginate, 'page', ''),
                'perpage'       => (int) array_get($paginate, 'perpage', ''),
                'totalpage'     => (int) array_get($paginate, 'totalpage', ''),
                'offset'        => (int) $this->offset,
                'limit'         => (int) $this->limit,
                'total_result'  => (int) count($records),
                'summary_count' => (int) array_get($paginate, 'records', '')
            ];

            $result['pagination'] = $pagination;
        }

        if ($code == 200 && !isset($records['msg'])) {
            $result['records'] = $records;
        } else {
            $result = $records;
        }

        if (!isset($result['msgError_en']) && isset($result['msgError']) ) 
        {
            $result['msgError_en'] = $result['msgError'];
            $result['msgError_mm'] = t_mm($result['msgError']);
        }

        return [$code => $result];
    }

    /**
     * Get search regex text mongo
     */
    protected function regexSearch($text)
    {
        return new Regex($text, 'i');
    }

    /**
     * Convert id mongo
     */
    protected function convertId($id)
    {
        return new ObjectID($id);
    }

    /**
     * Set sort dataList Mongo
     * @return array (default [created_at => -1])
     */
    protected function setSortDataListMongo(array $params)
    {
        //default sort
        $sort = ['created_at' => -1];

        if (isset($params['order']) && !empty($params['order'])) {
            $sort = [];
            foreach ($params['order'] as $vOrder) {
                $sort[$vOrder['column']] = $vOrder['dir'] === 'asc' ? 1 : -1;
            }
        }

        if (isset($params['orderby']) && !empty($params['orderby'])) {
            $sort = [];
            $orderby = explode('|' , $params['orderby']);
            $sort[$orderby[0]] = $orderby[1] === 'asc' ? 1 : -1;
        }

        return $sort;
    }

    /**
     * Set sort dataList My SQL
     * @return array (default [created_at => -1])
     */
    protected function setSortDataListMySql(array $params)
    {
        //default sort
        $sort = ' id asc ';

        if (isset($params['order']) && !empty($params['order'])) {
            $sort = ' ';
            $str  = '';
            foreach ($params['order'] as $vOrder) {
                $sort .= $vOrder['column'] . " " . ($vOrder['dir'] === 'asc' ? 'asc' : 'desc');
                $str  = ',';
            }
        }

        if (isset($params['orderby']) && !empty($params['orderby'])) {
            $sort = ' ';
            $orderby = explode('|' , $params['orderby']);
            $sort .= $orderby[0] . " " . ($orderby[1] === 'asc' ? 'asc' : 'desc');
        }


        return $sort;
    }

    /**
     * Set search dataList Mongo
     * @return array (default [deleted_at = null])
     */
    protected function setSearchDataListMongo(array $params)
    {
        //default search
        $search = [];

        if (isset($params['search']) && !empty($params['search'])) {
            foreach ($params['search'] as $kSearch => $vSearch) {
                $search[$vSearch['name']] = $this->regexSearch(trim($vSearch['value']));
            }
        }

        return $search;
    }

    /**
     * Set search dataList My Sql
     * @return array (default [deleted_at = null])
     */
    protected function setSearchDataListMySql(array $params)
    {
        //default search
        $search = ' ';

        if (isset($params['search']) && !empty($params['search'])) {
            foreach ($params['search'] as $kSearch => $vSearch) {
                $search .= " AND " . $vSearch['name'] . " LIKE '%" . trim($vSearch['value']) . "%' ";
            }
        }

        return $search;
    }

    /**
     * Set search dataList Mongo
     * @return array ()
     */
    protected function setWhereDataTableMongo(array $params)
    {
        unset($params['start']);
        unset($params['length']);
        unset($params['offset']);
        unset($params['limit']);
        unset($params['order']);
        unset($params['orderby']);
        unset($params['search']);
        unset($params['draw']);
        unset($params['columns']);

        //default search
        $where = [];

        if (isset($params) && !empty($params)) {
            foreach ($params as $k => $value) {
                $where[$k] = $value;
            }
        }

        return $where;
    }

    /**
     * Set search dataList
     * @return array ()
     */
    protected function setWhereDataTableMySql(array $params)
    {
        unset($params['start']);
        unset($params['length']);
        unset($params['offset']);
        unset($params['limit']);
        unset($params['order']);
        unset($params['orderby']);
        unset($params['search']);
        unset($params['draw']);
        unset($params['columns']);

        //default search
        $where = '';

        if ( isset($params['start_date']) && $params['start_date'] != '' && 
              isset($params['end_date']) && $params['end_date'] != '' ) 
        {
            $where .= " AND start_date <= '" . $params['start_date'] . "' 
                        AND end_date >= '". $params['end_date'] ."'  ";

            unset($params['start_date']);
            unset($params['end_date']);
        }

        if (isset($params) && !empty($params)) {
            foreach ($params as $k => $value) {
                $where .= " AND " . $k . " LIKE '%" . $value . "%' ";
            }
        }

        return $where;
    }

    protected function setCustomWhere()
    {
        //default customwhere
        $where = '';

        $current_date = date("Y-m-d");
        $where .= " AND status = 'active' AND start_date <= '".$current_date." 00:00:00' AND end_date >= '".$current_date." 23:59:59'";
        return $where;
    }

    /**
     * Get id mongo multi Mongo
     * @return array (default [])
     */
    protected function getMultiIdMongo(array $params)
    {
        $id = [];

        if (!empty($params)) {
            foreach ($params as $vData) {
                if (isset($vData) && !empty($vData)) {
                    $value = trim($vData);
                    $id[]  = $this->convertId($value);
                }
            }
        }

        return $id;
    }

    /**
     * Get id mongo multi My Sql
     * @return array (default [])
     */
    protected function getMultiIdMySql(array $params)
    {
        $id = '';
        $str = '';
        if (!empty($params)) {
            foreach ($params as $vData) {
                if (isset($vData) && !empty($vData)) {
                    $value = trim($vData);
                    $id  .= $str . $value;
                    $str  = ',';
                }
            }
        }

        return $id;
    }

}

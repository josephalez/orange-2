<?php namespace App\Helpers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

//TODO: HACERLE UN METODO PARA LOS ORDENAMIENTOS POR PROPIEDAD

class MPage
{

  public $page;
  public $perPage;
  public $minPage;
  public $maxPage;
  public $items;
  public $itemsTotal;

  private $model;
  private $request;

  public $id;

  private $frontPages;
  private $backPages;

  /**/
  public $filters = [

  ];

  public $orders = [

  ];

  private $filtersList = [
    /*'substate'    => 'substate',
    'agendaday'   => 'agenda',
    'subordinado' => 'subordinado',
    'rut'         => 'rut'*/
  ];

  private $ordersList = [
    "id" => "id",
    'name' => 'name',
    'gender' => 'gender',
    "assigned_to" => "assigned_to",
    "email" => "email",
    "role" => "role",
    "edit" => "edit",
    //"client" => "client",
    "seller" => "seller",
    //"supervisor" => "supervisor",
    //"analyst" => "analyst",
    "observation" => "observation",
    'originalName' => 'originalName',
    'created_at' => 'created_at',
    "code" => "code",
    "price" => "price",
    "activation_price" => "activation_price",
    "points" => "points",
    //"equipment" => "equipment",
    "prepaid_price" => "prepaid_price",
    "plan" => "plan",
    "prepaid_price"=>"prepaid_price",
    "delivery_address"=>"delivery_address",
    "delivery_commune"=>"delivery_commune",
    "clientFullName" => "clients.name",
    "supervisor"=>"supervisor",
  ];

  public $ordersKeys = [
    //esto debe estar vaciado
  ];

  private $normalFilters = [
    /*'substate',
    'agenda',
    'rut'*/
  ];

  private $normalOrders = [//Aqui van las ordenes genericas
    "id",
    'name',
    'gender',
    "assigned_to",
    "email",
    "role",
    "edit",
    //"client",
    "seller",
    //"supervisor",
    //"analyst",
    "observation",
    'originalName',
    'created_at',
    "code",
    "price",
    "activation_price",
    "points",
    "plan",
    //"equipment",
    "prepaid_price",
    "clientFullName",
    "delivery_address",
    "delivery_commune",
    "supervisor",
  ];

  public $filtersKeys = [
    //esto debe estar vaciado
  ];

  private $tableName = '';
  /**/

  function __construct($model,Request $request = null , $perPage = 10, $id = '', $tableName = ''){
    $this->page       = 1;
    $this->perPage    = $perPage;

    $this->minPage    = 1;
    $this->maxPage    = 1;

    $this->items      = [];
    $this->itemsTotal = 0;

    $this->request    = $request;
    $this->model      = $model;
    $this->id         = $id;

    $this->frontPages = 4;
    $this->backPages  = 4;

    $this->tableName  = $tableName;
  }

  function requestProcess(){
    if ($this->request->input($this->id.'page'))
      $this->page = (integer) $this->request->input($this->id.'page');

    return $this->getFilters()->getOrderby();
  }

  function getTotals(){
    $modelCount = clone $this->model;

    $this->itemsTotal =
    $modelCount->distinct($this->tableName.'.id')->count($this->tableName.'.id');
    $this->maxPage = ceil( $this->itemsTotal / $this->perPage );

    return $this;
  }

  function processFiltersModel(){

    foreach ($this->filters as $key => $value){
      if (!empty($value) || $value == '0')
        if (in_array($key, $this->normalFilters)){
            $this->model->where($key,'=',$value);
        } else {
          switch ($key) {
            case 'subordinado':
              //uploader
              if (Auth::user()->role == 'bo general' || Auth::user()->role == 'backoffice')
                $this->model->where('supervisor','=',$value);

              if (Auth::user()->role == 'supervisor')
                $this->model->where('ejecutivo','=',$value);
            break;
          }
        }
    }

    return $this;
  }

  function processOrdersModel(){

    foreach ($this->orders as $key => $value){
      if (!empty($value) || $value == '0')
        if (in_array($key, $this->normalOrders)){
            $this->model->orderBy($this->tableName!=""?$this->tableName.".".$key:$key ,$value);
        } else {
          switch ($key) {
            /*Ordenamientos no genericos... que no deberian haber por que solo hay DESC y ASC*/
          }
      }
    }

    return $this;
  }

  function getQuery(){
    $this->items =
    $this->model
    ->take($this->perPage)
    ->skip(($this->page - 1) * $this->perPage)
    ->get();

    return $this;
  }

  function pageValidate(){
    if ($this->page < $this->minPage) $this->page = (integer) $this->minPage;
    if ($this->page > $this->maxPage) $this->page = (integer) $this->maxPage;

    //var_dump($this->page);exit();

    return $this;
  }

  function execute(){
    $this->requestProcess()->processFiltersModel()->processOrdersModel()->getTotals()->pageValidate()->getQuery();
    return $this;
  }

  function getFilters(){
    $filtersList = $this->filtersList;
    foreach ($filtersList as $key => $value) {
      $this->filtersKeys[$value] = $this->id.'filters_'.$key;
      if (
        !empty($this->request->input($this->id.'filters_'.$key))
        || $this->request->input($this->id.'filters_'.$key) == '0' //Esto es por que el '0' lo detecta como empty
      )
        $this->filters[$value] = $this->request->input($this->filtersKeys[$value]);
      else
        $this->filters[$value] = null;
    }
    return $this;
  }

  function getOrderby(){
    $ordersList = $this->ordersList;
    foreach ($ordersList as $key => $value) {
      $this->ordersKeys[$value] = $this->id.'orderby_'.$key;
      if (
        !empty($this->request->input($this->id.'orderby_'.$key))
        || $this->request->input($this->id.'orderby_'.$key) == '0' //Esto es por que el '0' lo detecta como empty
      )
        $this->orders[$value] = $this->request->input($this->ordersKeys[$value]);
      else
        $this->orders[$value] = null;
    }
    return $this;
  }

  function getPaginate(){

    $backPages = $this->backPages;
    $frontPages = $this->frontPages;

    $pagesArray = [];

    for ($i=1; $i <= $backPages; $i++) {
      $page = $this->page - $i;
      if (!($page < $this->minPage) && !($page > $this->maxPage))
        array_unshift ($pagesArray, $page);
      else
        $frontPages += 1;
    }

    //var_dump($pages);exit();
    $pagesArray[] = $this->page;

    //var_dump($frontPages);exit();

    for ($i=1; $i <= $frontPages; $i++) {
      $page = $this->page + $i;
      if (!($page < $this->minPage) && !($page > $this->maxPage))
        $pagesArray[] = $page;
      else
        $backPages += 1;
    }

    for ($i=1; $i <= $backPages; $i++) {
      $page = $this->page - $i;
      if (!($page < $this->minPage) && !($page > $this->maxPage) && !in_array($page, $pagesArray))
        array_unshift ($pagesArray, $page);
    }

    $resPages = [];

    $allRequest = $this->request->all();
    $keyRequest = $this->id.'page';
    $allRequestUrl = '';
    foreach ($allRequest as $key => $value) {
      if ($key != $keyRequest)
        $allRequestUrl .= '&'.$key.'='.$value;
    }

    for ($i=0; $i < sizeof($pagesArray); $i++) {
      $resPages[] = [
        'page'    => (integer) $pagesArray[$i],
        'url'     => $keyRequest.'='.$pagesArray[$i].$allRequestUrl,
        'current' => ($pagesArray[$i] == $this->page) ? true : false
      ];
    }

    $backPage = null;
    $nextPage = null;

    //var_dump($resPages[0]['current']);exit();

    if (!$resPages[0]['current'])
      foreach ($resPages as $key => $value)
        if ($value['current'])
          $backPage = $resPages[$key - 1];


    if (!$resPages[sizeof($resPages) - 1]['current'])
      foreach ($resPages as $key => $value)
        if ($value['current'])
          $nextPage = $resPages[$key + 1];

    return [
      'pages' => $resPages,
      'back'  => $backPage,
      'next'  => $nextPage
    ];
  }

  function getResult(){
    return [
      'items'       => $this->items,
      'pages'       => $this->maxPage,
      'total'       => $this->itemsTotal,
      'perpage'     => $this->perPage,
      'page'        => $this->page,
      'id'          => $this->id,
      'paginate'    => $this->getPaginate(),
      'filters'     => $this->filters,
      'filtersKeys' => $this->filtersKeys,
      'ordersKeys'  => $this->ordersKeys,
      'pageKey'     => $this->id.'page'
    ];
  }

  static function paginate($model, Request $request = null, $perPage = 10, $id = '', $tableName = ''){

    $OPaginator = new MPage($model, $request, $perPage, $id, $tableName);
    return $OPaginator->execute()->getResult();

  }

}

?>

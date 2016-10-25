<?php
namespace App\Http\Library;

use Illuminate\Contracts\Pagination\Paginator;

class Transformer{
    private $data = [];
    public function __construct(Paginator $page_data)
    {
        $this->data = $page_data->toArray();
        return $this;
    }

    public function json(){
        return $this->data;
    }

    public function transform(){
        return $this;
    }
}


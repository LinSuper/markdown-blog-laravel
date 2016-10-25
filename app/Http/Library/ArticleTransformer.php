<?php
namespace App\Http\Library;
use Illuminate\Contracts\Pagination\Paginator;

class ArticleTransformer extends Transformer {
    public function __construct(Paginator $page_data)
    {
        parent::__construct($page_data);
    }

    public function transform()
    {

    }
}